# setup.ps1 — jalankan di folder C:\xampp\htdocs\SKIPM (PowerShell as Admin recommended)

$project = Split-Path -Parent $MyInvocation.MyCommand.Path
Set-Location $project

# 1. Create .venv if not exists
if (-not (Test-Path ".\.venv")) {
    Write-Host "Creating virtual environment..."
    python -m venv .venv
} else {
    Write-Host ".venv already exists."
}

# 2. Activate venv for current session
Write-Host "Activating virtualenv..."
. .\.venv\Scripts\Activate.ps1

# 3. Create app folder if missing
if (-not (Test-Path ".\app")) {
    New-Item -ItemType Directory -Path ".\app" | Out-Null
    Write-Host "Created app folder."
}

# 4. Create minimal requirements-win.txt if missing
$reqFile = ".\app\requirements-win.txt"
if (-not (Test-Path $reqFile)) {
    @"
fastapi
uvicorn[standard]
tensorflow-cpu
pillow
numpy
python-multipart
"@ | Out-File -Encoding utf8 $reqFile -Force
    Write-Host "Created $reqFile"
} else {
    Write-Host "$reqFile already exists."
}

# 5. Upgrade pip & install packages
Write-Host "Upgrading pip & installing packages (this may take several minutes)..."
python -m pip install --upgrade pip setuptools wheel
pip install -r $reqFile

Write-Host "Setup complete. To run API: .venv\\Scripts\\Activate.ps1 ; uvicorn app.main:app --host 0.0.0.0 --port 8000"
