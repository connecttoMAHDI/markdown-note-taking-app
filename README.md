# Markdown Note-Taking App

## Overview

This is a simple **Markdown Note-Taking App** built with Laravel. It allows users to create, edit, and store markdown notes, check their grammar, and render them into HTML. The project is inspired by the [Markdown Note-Taking App](https://roadmap.sh/projects/markdown-note-taking-app) Challenge from [roadmap.sh](roadmap.sh).

## Features

- **Markdown File Handling:** Users can write and save notes in markdown format.
- **Grammar Checking:** Extract plain text from markdown and check for grammar errors using LanguageTool API.
- **Markdown Rendering:** Converts markdown into HTML for better readability.
- **RESTful API:** Exposes endpoints to manage notes.

## Routes

### **1. Check Grammar in Markdown**

- **Endpoint:** `POST /api/v1/notes/check-grammar`
- **Description:** Accepts markdown text, extracts plain text, and checks grammar.
- **Request Example:**
  ```json
  { "markdown": "This is a gramatical mistake." }
  ```
- **Response Example:**
  ```json
  {
    "message": "Grammar check completed.",
    "data": {
        "original": "This is a gramatical mistake.\n",
        "errors": [
            {
                "message": "Spelling mistake",
                "original": "This is a gramatical mistake.",
                "corrected": "This is a grammatical mistake.",
                "subject": "gramatical",
                "offset": 10,
                "length": 10,
                "suggestions": [
                    "grammatical",
                    "dramatical"
                ]
            }
        ],
        "warnings": {
            "incompleteResults": false
        },
        "corrected": "This is a grammatical mistake.\n"
    },
    "meta": {
        "language": "English (US)"
    }
  }
  ```

### **2. Save a Markdown Note**

- **Endpoint:** `POST /api/v1/notes`
- **Description:** Saves a markdown note.
- **Request Example:**
  ```json
  {
    "title": "My First Note",
    "content": "# Heading\nThis is a sample markdown note."
  }
  ```

### **3. List All Notes**

- **Endpoint:** `GET /api/v1/notes`
- **Description:** Retrieves all saved markdown notes. (raw markdown)

### **4. Get a single Note**

- **Endpoint:** `GET /api/v1/notes/{id}`
- **Description:** Fetches a specific markdown note. (raw markdown)

### **5. Render Markdown to HTML**

- **Endpoint:** `GET /api/v1/notes/{id}/render`
- **Description:** Converts markdown content to HTML.

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

## API Testing

A Postman-compatible collection file, `markdown-note-taking-app.json`, is available in the project root. You can import it into Postman or Talend API Tester for easy testing of API endpoints.

### Steps to Import:

1. Open Postman or Talend API Tester.
2. Click on `Import`.
3. Select `markdown-note-taking-app.json` from the project root.
4. Start testing the API endpoints.
