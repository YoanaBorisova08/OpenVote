# 🗳 Open Vote
### Web Platform for Publishing Suggestions and Voting
[Link to the site](https://open-vote.yoanaborisova.com/)

---

## 📌 Project Overview

**Open Vote** is a web-based platform where users can publish suggestions, vote on ideas, and track their progress.  
The system includes user authentication and an administrative panel for content management.

The application is built using:

- HTML5
- CSS3
- Pure PHP (no frameworks)
- MySQL
- PDO (Prepared Statements)
- Full CRUD operations

---

## 🎯 Project Objectives

The platform allows:

- Users to submit suggestions or ideas
- Other users to browse and vote
- Administrators to manage content and update statuses
- Secure user authentication and role-based access

---

## 👥 User Roles

### 👤 Regular User

- Register an account
- Login / Logout
- Create new suggestion
- Edit and delete own suggestions
- View all suggestions
- Vote (1 vote per user per suggestion)
- Search suggestions
- Filter by status
- Sort by date or votes

---

### 🛠 Administrator

- Login as administrator
- View all suggestions
- Change suggestion status:
  - New
  - Approved
  - In Progress
  - Completed
  - Rejected
- Delete inappropriate content
- (Optional) Add administrator comment

---

## 🌐 Application Structure

### Public Section

#### 🏠 Home Page
- Latest suggestions
- Most voted suggestions
- Search bar

#### 📋 Suggestions List
- Sort by:
  - Date
  - Number of votes
- Filter by status

#### 📄 Suggestion Details Page
- Title
- Description
- Author
- Created date
- Status
- Total votes
- Vote button (visible when logged in)

---

### 🔐 Registered User Section

- Registration page
- Login page
- User profile page
  - User information
  - "My Suggestions" list
  - Edit/Delete options
- Create suggestion page
- Edit suggestion page

---

### ⚙ Administrator Panel

- View all suggestions
- Change suggestion status
- Delete suggestions
- Add administrative comment (optional)

---

## 🗄 Database Structure

Main database tables:

- `users`
- `suggestions`
- `votes`
- `comments`

### Relationships

- One user can create many suggestions
- One suggestion can have many votes
- One user can vote once per suggestion
- Suggestions have a status managed by administrator

---

## 🔄 CRUD Functionality

The system implements full CRUD operations:

- **Create** – Add new suggestions
- **Read** – Display suggestions
- **Update** – Edit suggestions / Update status
- **Delete** – Remove suggestions

---

## 🔒 Security Features

- Password hashing using `password_hash()`
- PDO prepared statements
- Protection against SQL Injection
- Role-based access control
- One vote per user per suggestion
- Session-based authentication

---

## 🚀 Installation & Setup

### 1️⃣ Clone the repository

```
git clone https://github.com/YoanaBorisova08/OpenVote.git
```
### 2️⃣ Import the provided SQL file into MySQL.

### 3️⃣ Configure database connection in the project settings.

### 4️⃣ Run the project using XAMPP:

```
http://localhost/open-vote
```
## 🛠 Technologies Used

- HTML5

- CSS3

- PHP 8+

- MySQL

- XAMPP

## 👩‍💻 Author

Yoana Borisova
Web Application Development Project
2026
