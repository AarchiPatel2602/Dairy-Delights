const express = require('express');
const mysql = require('mysql2');
const cors = require('cors');
const path = require('path');

const app = express();
app.use(cors());
app.use(express.json());

// Serve static files from 'htdocs/Dairy_product'
app.use(express.static(path.join(__dirname)));

// MySQL Database Connection
const db = mysql.createConnection({
    host: 'localhost',
    user: 'root',
    password: '',  
    database: 'dairy_products'
});

db.connect(err => {
    if (err) console.error('Database connection failed:', err);
    else console.log('Connected to MySQL database');
});

// API to fetch products
app.get('/products', (req, res) => {
    const sql = 'SELECT * FROM products';
    db.query(sql, (err, results) => {
        if (err) res.status(500).send('Database query failed');
        else res.json(results);
    });
});

// Start server
const PORT =5000;
app.listen(PORT, () => {
    console.log(`Server running on http://localhost:${PORT}`);
});
