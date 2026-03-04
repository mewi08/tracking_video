# Video Tracking Web Platform (PHP + JavaScript)

## 📌 Description

This project is a simple video tracking web platform built with **PHP**, **JavaScript**, and **MySQL**.

It allows:

* Students to watch course videos
* Automatic tracking of video progress
* Storing viewing data in a database
* Integration with external platforms (e.g., Moodle via external link)

---

## 🚀 Features

* Video player with HTML5
* Real-time time tracking
* Stores:

  * user_id
  * video_id
  * watched time
  * completion status
  * last access date
* Simple API endpoint built in PHP
* Ready for deployment on hosting services or Vercel (with PHP support)

---

## 🛠 Technologies Used

* PHP 8+
* JavaScript (Vanilla JS)
* MySQL
* HTML5 Video API
* CSS3

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

### 2️⃣ Configure database

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

### 3️⃣ Start local server

If using XAMPP:

* Place project inside `htdocs`
* Start Apache and MySQL
* Open:

```
http://localhost/tracking/
```

---

## 🔄 How Tracking Works

1. User loads the page
2. Selects a video
3. JavaScript listens for:

   * `timeupdate`
   * `pause`
   * `ended`
4. When the video finishes, JS sends a POST request to:

```
/api/save_watch_time.php
```

5. PHP saves data into MySQL

---


## 🌐 Moodle Integration

This system can be integrated with Moodle by:

* Adding it as an External URL
* Passing `user_id` as a GET parameter
* Storing tracking information linked to Moodle users

Example:

```
https://yourdomain.com/index.php?user_id=123
```

---

## 📈 Future Improvements

* Progress percentage tracking
* Dashboard with reports
* Video completion validation (e.g., 80% watched rule)
* xAPI integration
* Role-based access (admin/student)

---

## 📄 License

This project is open-source and free to use for educational purposes.

```
```
