const { createUniqueName, createAutoUsername } = require('./util.js')

const generateUsername = name => {
  if (!!name.trim()) {
    let convertToArray = name.split(' ')
    return createUniqueName(convertToArray)
  } else {
    return 'Error: no name found, unable to create username'
  }
}

const generateRandomName = username_length => {
  return createAutoUsername(username_length)
}

console.log(createAutoUsername(1))

module.exports = { generateUsername, generateRandomName }
