<?php

$searchTerm = $_GET['term'];

$presidents = array(
  "George Washington",
  "John Adams",
  "Thomas Jefferson",
  "James Madison",
  "James Monroe",
  "John Quincy Adams",
  "Andrew Jackson",
  "Martin Van Buren",
  "William Henry Harrison",
  "John Tyler",
  "James Knox Polk",
  "Zachary Taylor",
  "Millard Fillmore",
  "Franklin Pierce",
  "James Buchanan",
  "Abraham Lincoln",
  "Andrew Johnson",
  "Ulysses Simpson Grant",
  "Rutherford Birchard Hayes",
  "James Abram Garfield",
  "Chester Alan Arthur",
  "Grover Cleveland",
  "Benjamin Harrison",
  "Grover Cleveland",
  "William McKinley",
  "Theodore Roosevelt",
  "William Howard Taft",
  "Woodrow Wilson",
  "Warren Gamaliel Harding",
  "Calvin Coolidge",
  "Herbert Clark Hoover",
  "Franklin Delano Roosevelt",
  "Harry S. Truman",
  "Dwight David Eisenhower",
  "John Fitzgerald Kennedy",
  "Lyndon Baines Johnson",
  "Richard Milhous Nixon",
  "Gerald Rudolph Ford",
  "James Earl Carter, Jr.",
  "Ronald Wilson Reagan",
  "George Herbert Walker Bush",
  "William Jefferson Clinton",
  "George Walker Bush",
  "Barack Hussein Obama"
);
	
function filter($president) {
  global $searchTerm;
  return stripos($president, $searchTerm) !== false;
}

print(json_encode(array_values(array_filter($presidents, "filter"))));

?>