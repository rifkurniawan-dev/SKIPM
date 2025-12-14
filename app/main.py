# main.py
import uvicorn
from fastapi import FastAPI, UploadFile, File, HTTPException
from fastapi.middleware.cors import CORSMiddleware
from fastapi.responses import JSONResponse
import numpy as np
from PIL import Image
import io
import tensorflow as tf
import os

MODEL_PATH = "model_last_ikan.h5"

# Threshold fleksibel via environment variable
VERY_FRESH_THRESHOLD = float(os.getenv("VERY_FRESH_THRESHOLD", 0.9))  # ≥90% → Sangat Segar
FRESH_THRESHOLD = float(os.getenv("FRESH_THRESHOLD", 0.7))            # 70–89.99% → Segar
NOT_FRESH_THRESHOLD = float(os.getenv("NOT_FRESH_THRESHOLD", 0.6))    # 60–69.99% → Tidak Segar

try:
    model = tf.keras.models.load_model(MODEL_PATH)
except Exception as e:
    print(f"Gagal load model: {e}")
    model = None

INPUT_SIZE = (224,224)

app = FastAPI()
app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],
    allow_methods=["*"],
    allow_headers=["*"]
)

def preprocess_image(image_bytes: bytes):
    img = Image.open(io.BytesIO(image_bytes)).convert("RGB")
    img = img.resize(INPUT_SIZE)
    arr = np.array(img) / 255.0
    arr = np.expand_dims(arr, axis=0)
    return arr

def _to_probabilities(raw_arr):
    """
    Convert raw model output to a probability vector (sum to 1).
    Handles:
      - single-output sigmoid (shape (1,) or (1,1))
      - already probabilistic vector (values in [0,1] and sum≈1)
      - logits (apply softmax)
    Returns numpy array of probs (dtype float64).
    """
    arr = np.array(raw_arr, dtype=np.float64).reshape(-1)
    # single value -> treat as sigmoid output or logits for single unit
    if arr.size == 1:
        p = float(arr[0])
        # if outside [0,1], apply sigmoid
        if p < 0.0 or p > 1.0:
            p = 1.0 / (1.0 + np.exp(-p))
        return np.array([1.0 - p, p], dtype=np.float64)
    # multi-output: check if already probabilities (0..1 and sum ~1)
    if np.all(arr >= 0.0) and np.all(arr <= 1.0) and np.isclose(arr.sum(), 1.0, rtol=1e-3, atol=1e-3):
        return arr
    # otherwise treat as logits -> softmax
    exp = np.exp(arr - np.max(arr))
    probs = exp / exp.sum()
    return probs

@app.post("/predict")
async def predict(file: UploadFile = File(...)):
    if model is None:
        raise HTTPException(status_code=500, detail="Model tidak tersedia di server")
    
    contents = await file.read()
    img_array = preprocess_image(contents)
    raw_preds = model.predict(img_array)               # may be logits or probs
    raw = np.array(raw_preds).reshape(-1)

    probs = _to_probabilities(raw)
    max_idx = int(np.argmax(probs))
    confidence = float(probs[max_idx])  # 0..1

    # Konversi ke persen untuk output
    confidence_pct = confidence * 99.9

    # Tentukan label 4-level berdasarkan threshold env vars
    if confidence >= VERY_FRESH_THRESHOLD:
        predicted_label = "Sangat Segar"
    elif confidence >= FRESH_THRESHOLD:
        predicted_label = "Segar"
    elif confidence >= NOT_FRESH_THRESHOLD:
        predicted_label = "Kurang Segar"
    else:
        predicted_label = "Tidak Segar"
    

    return JSONResponse(content={
        "predicted_class": predicted_label,
        "confidence": round(confidence_pct, 2),
        # debug helpers (opsional): uncomment jika butuh inspeksi
        # "raw_output": raw.tolist(),
        # "probs": probs.tolist(),
        # "predicted_index": max_idx
    })

if __name__ == "__main__":
    uvicorn.run(app, host="127.0.0.1", port=8000)
