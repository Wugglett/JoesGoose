// To create the main leaderboard table,
// search SQL database for all approved entries then print them onto the html table as tr elements (+td elements)
// make sure to group them by complete_time ascending
// will need a table to hold Submissions(run_id, user_id, username, complete_time, date_submitted, platform, approved)

// Should have a table of unapproved runs for mods to look at on the mod page

const mysql = require('mysql');
const connection = mysql.createConnection({
  host: 'localhost',
  user: 'user',
  password: '',
  database: 'Joe'
});
connection.connect((err) => {
  if (err) throw err;
  console.log('Connected!');
});