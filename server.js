const express = require('express');
const mysql = require('mysql2');
const bodyParser = require('body-parser');

const app = express();
const port = 3000;

app.use(bodyParser.urlencoded({ extended: false }));
app.use(bodyParser.json());

// MySQL configuration
const connection = mysql.createConnection({
  host: 'localhost',
  user: 'root',
  password: '',
  database: 'exam',
});

// Connect to MySQL
connection.connect(function (err) {
  if (err) {
    console.error('Error connecting to MySQL: ' + err.stack);
    return;
  }
  console.log('Connected to MySQL as id ' + connection.threadId);
});

// Serve the index.html file
app.get('/', function (req, res) {
  res.sendFile(__dirname + '/index.html');
});

// Handle form submission
app.post('/submit', function (req, res) {
  const question = req.body.question;
  const options = req.body.options;
  const correctOption = req.body.correctOption;


  // Insert question and options into the database
  const query = 'INSERT INTO question (question, options, correct_option) VALUES (?, ?, ?)';
  connection.query(query, [question, JSON.stringify(options), correctOption], function (error, results, fields) {
    if (error) {
      console.error('Error inserting data: ' + error.stack);
      res.status(500).json({ message: 'Error inserting data into the database.' });
      return;
    }
    res.json({ message: 'Data inserted successfully.' });
  });
});

// Start the server
app.listen(port, function () {
  console.log('Server listening on port ' + port);
});
