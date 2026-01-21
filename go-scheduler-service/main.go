package main

import (
	"bytes"
	"encoding/json"
	"fmt"
	"net/http"
	"os"
	"strings"
	"time"
)

type User struct {
	ID    int    `json:"id"`
	Name  string `json:"name"`
	Email string `json:"email"`
}

func main() {
	phpAPI := os.Getenv("PHP_API_URL")
	pythonAPI := os.Getenv("PYTHON_API_URL")

	if phpAPI == "" || pythonAPI == "" {
		fmt.Println("Error: Environment variables PHP_API_URL and PYTHON_API_URL must be set")
		return
	}

	for {
		fmt.Println("Checking for new data...")
		
		// Simulasi data untuk dikirim ke PHP API
		user := User{Name: "David Jonson", Email: "david@example.com"}
		jsonData, _ := json.Marshal(user)
		
		resp, err := http.Post(phpAPI, "application/json", bytes.NewBuffer(jsonData))
		if err != nil {
			fmt.Printf("Error connecting to PHP API: %v\n", err)
		} else {
			defer resp.Body.Close() // Pastikan body ditutup
			if resp.StatusCode == http.StatusCreated {
				var createdUser User
				if err := json.NewDecoder(resp.Body).Decode(&createdUser); err == nil {
					
					// Simpan ke file
					fileName := fmt.Sprintf("user_%d.json", createdUser.ID)
					fileData, _ := json.MarshalIndent(createdUser, "", "  ")
					os.WriteFile(fileName, fileData, 0644)

					// Cek filter "David"
					if strings.HasPrefix(createdUser.Name, "David") {
						fmt.Println("Nama diawali 'David', mengirim ke Python Service...")
						http.Post(pythonAPI, "application/json", bytes.NewBuffer(fileData))
					}
				}
			}
		}
		time.Sleep(30 * time.Second)
	}
}