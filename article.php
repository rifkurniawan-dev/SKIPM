<?php
include "koneksi.php";
$slug = $_GET['slug'] ?? '';
if (!$slug) { http_response_code(404); echo "Artikel tidak ditemukan"; exit; }

$stmt = $conn->prepare("SELECT a.title, a.summary, a.content, a.created_at, ad.username AS author FROM articles a JOIN admins ad ON a.author_id = ad.id_admin WHERE a.slug = ? AND a.is_published = 1 LIMIT 1");
$stmt->bind_param("s", $slug);
$stmt->execute();
$res = $stmt->get_result();
if ($res->num_rows === 0) { http_response_code(404); echo "Artikel tidak ditemukan atau belum dipublikasikan"; exit; }
$row = $res->fetch_assoc();
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <title><?= htmlspecialchars($row['title']) ?></title>
</head>
<body>
  <article>
    <h1><?= htmlspecialchars($row['title']) ?></h1>
    <p><small>Oleh <?= htmlspecialchars($row['author']) ?> — <?= htmlspecialchars($row['created_at']) ?></small></p>
    <?php if ($row['summary']): ?><p><em><?= htmlspecialchars($row['summary']) ?></em></p><?php endif; ?>
    <div><?= $row['content'] /* content mungkin mengandung HTML jika anda ingin rich text; lakukan sanitasi jika perlu */ ?></div>
  </article>
</body>
</html>
