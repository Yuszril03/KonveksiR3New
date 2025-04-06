const createUniqueName = (nameArr) => {
  let generatedUsername = "";

  for (const chunk of nameArr) {
    generatedUsername += chunk.toLowerCase();
  }
  return generatedUsername + "_" + randomNumbers();
};

const randomNumbers = () => {
  let num = Math.random().toString().substring(2, 6);
  return num;
};

const createAutoUsername = (length = 10) => {
  if (!Number.isInteger(length)) {
    return { error: `Invalid length, please use integer` };
  }
  if (length > 20 || length < 10) {
    return {
      error: `not valid length to generate random username, please use number between 10 to 20`,
    };
  }
  let randomUsername = "";
  let counter = 0;
  const characters = `ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789`;

  while (counter < length) {
    randomUsername += characters.charAt(Math.floor(Math.random() * length));
    counter += 1;
  }
  return randomUsername;
};

export default { createUniqueName, createAutoUsername };
