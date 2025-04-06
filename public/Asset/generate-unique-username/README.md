# Introduction

Javascript library to generate you unique username provide by your name

**Generate username with your FullName**

```javascript
generateUsername(name: String: required)
```

**Generate randome username**

```javascript
generateRandomName(username_length: Number: optional | defaultValue: 10)
```

# Installation

```javascript
npm install generate-unique-username
```

# Usage

```javascript
const { generateUsername } = require("generate-unique-username");

console.log(generateUsername("Aman Sultan Baig"));
```

### Expected Output

```javascript
amansultanbaig_1297;
```

```javascript
const { generateRandomName } = require("generate-unique-username");

console.log(generateRandomName(5));
```

### Expected Output

```javascript
ZbWNZ;
```
