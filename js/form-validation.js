function validateForm() {
  let isValid = true;
  const namePattern = /^[A-Za-z]+$/;
  const phonePattern = /^[0-9]+$/;

  // Validate first name
  const firstName = document.getElementById("firstName").value;
  if (!namePattern.test(firstName)) {
    document.getElementById("firstNameError").style.display = "block";
    isValid = false;
  } else {
    document.getElementById("firstNameError").style.display = "none";
  }

  // Validate last name
  const lastName = document.getElementById("lastName").value;
  if (!namePattern.test(lastName)) {
    document.getElementById("lastNameError").style.display = "block";
    isValid = false;
  } else {
    document.getElementById("lastNameError").style.display = "none";
  }

  // Validate phone number
  const phone = document.getElementById("phone").value;
  if (!phonePattern.test(phone)) {
    document.getElementById("phoneError").style.display = "block";
    isValid = false;
  } else {
    document.getElementById("phoneError").style.display = "none";
  }

  return isValid;
}
