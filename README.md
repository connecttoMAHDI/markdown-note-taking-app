# Markdown Note-Taking App

## Overview

This is a simple **Markdown Note-Taking App** built with Laravel. It allows users to create, edit, and store markdown notes, check their grammar, and render them into HTML. The project is inspired by the [Markdown Note-Taking App](https://roadmap.sh/projects/markdown-note-taking-app) Challenge from [roadmap.sh](roadmap.sh).

## Features

- **Markdown File Handling:** Users can write and save notes in markdown format.
- **Grammar Checking:** Automatically checks grammar using an API before saving notes.
- **Markdown Rendering:** Converts markdown into HTML for better readability.
- **RESTful API:** Exposes endpoints to manage notes.
- **File Upload Support:** Users can upload markdown (`.md`) files.

## Routes

### **1. Check Grammar in Markdown**

- **Endpoint:** `POST /notes/check_grammar`
- **Description:** Accepts markdown text, extracts plain text, and checks grammar.
- **Request Example:**
  ```json
  { "content": "This is a gramatical mistake." }
  ```
- **Response Example:**
  ```json
  {
    "original": "This is a gramatical mistake.",
    "corrected": "This is a grammatical mistake.",
    "suggestions": [
      { "error": "gramatical", "suggestion": "grammatical" }
    ]
  }
  ```

### **2. Save a Markdown Note**

- **Endpoint:** `POST /notes`
- **Description:** Saves a markdown note after grammar verification.
- **Request Example:**
  ```json
  {
    "title": "My First Note",
    "content": "# Heading\nThis is a sample markdown note."
  }
  ```

### **3. List All Notes**

- **Endpoint:** `GET /notes`
- **Description:** Retrieves all saved markdown notes.

### **4. Get a Note in Markdown Format**

- **Endpoint:** `GET /notes/{id}`
- **Description:** Fetches a specific markdown note.

### **5. Render Markdown to HTML**

- **Endpoint:** `GET /notes/{id}/render`
- **Description:** Converts markdown content to HTML.
- **Response Example:**
  ```json
  {
    "id": 1,
    "title": "My First Note",
    "html": "<h1>Heading</h1><p>This is a sample markdown note.</p>"
  }
  ```

## Installation

### **1. Clone the Repository**

```sh
 git clone https://github.com/connecttoMAHDI/markdown-note-taking-app.git
 cd markdown-note-taking-app
```

### **2. Install Dependencies**

```sh
 composer install
```

### **3. Set Up Environment Variables**

Copy `.env.example` to `.env` and configure the database.

```sh
 cp .env.example .env
```

Then, generate an application key:

```sh
 php artisan key:generate
```

### **4. Set Up Database**

```sh
 php artisan migrate
```

### **5. Insert some test data (optional)**

```sh
 php artisan db:seed
```

### **6. Run the Application**

```sh
 php artisan serve
```

The API will be available at `http://127.0.0.1:8000`.
