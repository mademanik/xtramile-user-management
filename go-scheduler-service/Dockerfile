# Gunakan versi 1.25 atau yang lebih baru
FROM golang:1.25-alpine

WORKDIR /app

# Copy file modul
COPY go.mod ./
# COPY go.sum ./ 

RUN go mod download

# Copy sisa kode
COPY . .

RUN go build -o main .

CMD ["./main"]