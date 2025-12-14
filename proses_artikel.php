<?php
// proses_artikel.php
session_start();
require_once 'koneksi.php';

// pastikan admin
if (!isset($_SESSION['id_admin'])) {
    http_response_code(403);
    echo json_encode(['status'=>'error','message'=>'Unauthorized']);
    exit;
}

$action = $_POST['action'] ?? null;

function slugify($text){
    $text = preg_replace('~[^\pL\d]+~u','-', $text);
    $text = iconv('utf-8','us-ascii//TRANSLIT', $text);
    $text = preg_replace('~[^-\w]+~','', $text);
    $text = trim($text,'-');
    $text = preg_replace('~-+~','-', $text);
    $text = strtolower($text);
    return $text ?: 'n-a';
}

$uploadDir = __DIR__ . '/uploads/articles/';
if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

if ($action === 'create') {
    $title = trim($_POST['title'] ?? '');
    $summary = trim($_POST['summary'] ?? '');
    $content = $_POST['content'] ?? '';
    $is_published = isset($_POST['is_published']) ? 1 : 0;
    $author_id = intval($_SESSION['id_admin']);

    if ($title === '' || $content === '') {
        echo json_encode(['status'=>'error','message'=>'Judul dan isi wajib diisi.']); exit;
    }

    // handle image upload
    $imageName = null;
    if (!empty($_FILES['image']['name'])) {
        $f = $_FILES['image'];
        if ($f['error'] === 0 && preg_match('/image\//', $f['type'])) {
            $ext = pathinfo($f['name'], PATHINFO_EXTENSION);
            $imageName = time() . '_' . bin2hex(random_bytes(6)) . '.' . $ext;
            move_uploaded_file($f['tmp_name'], $uploadDir . $imageName);
        }
    }

    $slug = slugify($title) . '-' . time();

    $stmt = $conn->prepare("INSERT INTO articles (title, slug, summary, content, image, is_published, author_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssiii", $title, $slug, $summary, $content, $imageName, $is_published, $author_id);
    $ok = $stmt->execute();
    if ($ok) {
        echo json_encode(['status'=>'success','id'=>$conn->insert_id]);
    } else {
        echo json_encode(['status'=>'error','message'=>$conn->error]);
    }
    $stmt->close();
    exit;
}

if ($action === 'read') {
    $id = intval($_POST['id'] ?? 0);
    $stmt = $conn->prepare("SELECT id, title, slug, summary, content, image, is_published FROM articles WHERE id = ? LIMIT 1");
    $stmt->bind_param("i",$id);
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res->fetch_assoc();
    $stmt->close();
    if ($row) echo json_encode(['status'=>'success','data'=>$row]);
    else echo json_encode(['status'=>'error','message'=>'Not found']);
    exit;
}

if ($action === 'update') {
    $id = intval($_POST['id'] ?? 0);
    $title = trim($_POST['title'] ?? '');
    $summary = trim($_POST['summary'] ?? '');
    $content = $_POST['content'] ?? '';
    $is_published = isset($_POST['is_published']) ? 1 : 0;

    if ($title === '' || $content === '') {
        echo json_encode(['status'=>'error','message'=>'Judul dan isi wajib diisi.']); exit;
    }

    // get current image
    $stmt = $conn->prepare("SELECT image FROM articles WHERE id = ? LIMIT 1");
    $stmt->bind_param("i",$id);
    $stmt->execute();
    $res = $stmt->get_result();
    $cur = $res->fetch_assoc();
    $stmt->close();

    $imageName = $cur['image'] ?? null;
    // if new image uploaded, replace
    if (!empty($_FILES['image']['name'])) {
        $f = $_FILES['image'];
        if ($f['error'] === 0 && preg_match('/image\//', $f['type'])) {
            $ext = pathinfo($f['name'], PATHINFO_EXTENSION);
            $newImage = time() . '_' . bin2hex(random_bytes(6)) . '.' . $ext;
            move_uploaded_file($f['tmp_name'], $uploadDir . $newImage);
            // delete old
            if ($imageName && file_exists($uploadDir.$imageName)) unlink($uploadDir.$imageName);
            $imageName = $newImage;
        }
    }

    $stmt = $conn->prepare("UPDATE articles SET title=?, summary=?, content=?, image=?, is_published=?, updated_at = NOW() WHERE id = ?");
    $stmt->bind_param("sssiis", $title, $summary, $content, $imageName, $is_published, $id);
    $ok = $stmt->execute();
    if ($ok) echo json_encode(['status'=>'success']);
    else echo json_encode(['status'=>'error','message'=>$conn->error]);
    $stmt->close();
    exit;
}

if ($action === 'delete') {
    $id = intval($_POST['id'] ?? 0);
    // hapus gambar
    $stmt = $conn->prepare("SELECT image FROM articles WHERE id = ? LIMIT 1");
    $stmt->bind_param("i",$id);
    $stmt->execute();
    $res = $stmt->get_result();
    $cur = $res->fetch_assoc();
    $stmt->close();
    if ($cur && !empty($cur['image']) && file_exists($uploadDir . $cur['image'])) {
        @unlink($uploadDir . $cur['image']);
    }

    $stmt = $conn->prepare("DELETE FROM articles WHERE id = ?");
    $stmt->bind_param("i",$id);
    $ok = $stmt->execute();
    if ($ok) echo json_encode(['status'=>'success']);
    else echo json_encode(['status'=>'error','message'=>$conn->error]);
    $stmt->close();
    exit;
}

echo json_encode(['status'=>'error','message'=>'Unknown action']);
exit;
