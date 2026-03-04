# 🎬 Video Tracking Platform (PHP + JavaScript + MySQL)

## 📌 Description

Video Tracking Platform is a lightweight web application built with **PHP 8+, MySQL, and Vanilla JavaScript** that allows tracking student interaction with course videos.

The system stores viewing progress, completion percentage, and activity history.  
It can be integrated with platforms like Moodle via External URL or LTI.

---

## 🚀 Features

### 🎓 Student Side

- HTML5 video player
- Real-time progress tracking
- Automatic saving of watched time
- Resume playback from last position
- Completion detection based on percentage

### 👨‍💼 Admin Side

- Video upload
- Enable / Disable videos
- View tracking records
- Monitor:
  - Student ID
  - Student name (if available)
  - Video title
  - Percentage watched
  - Status (in_progress / completed)
  - Started at
  - Completed at
  - Last activity

---

## 🛠 Tech Stack

- PHP 8+
- MySQL
- Composer
- Vanilla JavaScript
- HTML5 Video API
- CSS3
- MVC Architecture (Controllers / Models / Views)

---

## 📋 Requirements

- PHP >= 8.0
- MySQL >= 5.7
- Composer
- Apache or Nginx
- XAMPP (recommended for local development)

---

## 📂 Project Structure

```
tracking/
│
├── app/
│   ├── api/
│   │   ├── save_watch_time.php             # API endpoint for saving tracking data  
│   │   ├── toggle_video.php                
│   │   └── upload_video.php 
│   │           
│   ├── controllers/
│   │   ├── VideoController.php
│   │   └── VideoTrackingController              
│   │   
│   ├── database/
│   │   └── db.sql                          # Database
│   │
│   └── models/ 
│       ├── Connection.php                  # Database connection
│       ├── Video.php
│       └── VideoTracking.php               # SQL query
│        
├── public/
│   ├── js/
│   │   ├── student.js                
│   │   ├── toggle.js                      
│   │   ├── upload.js                       
│   │   ├── video_admin.js                 
│   │   └── video_progress.js                # Video tracking logic   
│   │
│   └── video/                              # Videos
│  
├── views/
│   ├── templates/
│   │   ├── admin.html.php                                                  
│   │   └── student.html.php   
│   │
│   ├── admin.php
│   └── student.php
│
├── .env 
├── .gitignore 
├── composer.json
├── composer.lock 
├── index.php
├── launcher.php                               
└── README.md

```

---


## ⚙️ Installation

### 1️⃣ Clone repository

```
git clone https://github.com/mewi08/tracking.git
cd tracking
```
### 2️⃣ Install dependencies

```
composer install
```
### 3️⃣ Configure database

Create a `.env` file in the root of the project:

```
tracking/.env
```

Add your database credentials:

```env
DB_HOST=
DB_PORT=
DB_NAME=
DB_USER=
DB_PASS=
```

Do NOT edit credentials inside Connection.php.

### 4️⃣ Start local server

If using XAMPP:

* Place project inside `htdocs`
* Start Apache and MySQL
* Open:

```
http://localhost/tracking/
```

---

## 🔄 How Tracking Works

1. Student loads a video
2. JavaScript listens to videos events:

   * `timeupdate`
   * `pause`
   * `ended`
3. A POST request is sent to:

```
/app/api/save_watch_time.php
```

4. PHP saves data into MySQL
   * `Watched time`
   * `Percentage`
   * `Status`
   * `Timestamps`

5. Admin can view tracking data in dashboard.

---


## 🌐 Moodle Integration

This system can be integrated with Moodle by:

* Adding it as an External URL
* Passing `user_id` as a GET parameter
* Or integrating via LTI (recommended)

Example:

```
https://yourdomain.com/index.php?user_id=123
```
Tracking data will be linked to the provided user.

---

## 📄 License

This project is open-source and free to use for educational purposes.
