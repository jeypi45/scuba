const form = document.getElementById('form')
const firstname_input = document.getElementById('firstname-input')
const email_input = document.getElementById('email-input')
const password_input = document.getElementById('password-input')
const repeat_password_input = document.getElementById('repeat-password-input')
const error_message = document.getElementById('error-message')

form.addEventListener('submit', (e) => {
  let errors = []

  if(firstname_input){
    // If we have a firstname input then we are in the signup
    errors = getSignupFormErrors(firstname_input.value, email_input.value, password_input.value, repeat_password_input.value)
  }
  else{
    // If we don't have a firstname input then we are in the login
    errors = getLoginFormErrors(email_input.value, password_input.value)
  }

  if(errors.length > 0){
    // If there are any errors
    e.preventDefault()
    error_message.innerText  = errors.join(". ")
  }
})

function getSignupFormErrors(firstname, email, password, repeatPassword){
  let errors = []

  if(firstname === '' || firstname == null){
    errors.push('Firstname is required')
    firstname_input.parentElement.classList.add('incorrect')
  }
  if(email === '' || email == null){
    errors.push('Email is required')
    email_input.parentElement.classList.add('incorrect')
  }
  if(password === '' || password == null){
    errors.push('Password is required')
    password_input.parentElement.classList.add('incorrect')
  }
  if(password.length < 8){
    errors.push('Password must have at least 8 characters')
    password_input.parentElement.classList.add('incorrect')
  }
  if(password !== repeatPassword){
    errors.push('Password does not match repeated password')
    password_input.parentElement.classList.add('incorrect')
    repeat_password_input.parentElement.classList.add('incorrect')
  }


  return errors;
}

function getLoginFormErrors(email, password){
  let errors = []

  if(email === '' || email == null){
    errors.push('Email is required')
    email_input.parentElement.classList.add('incorrect')
  }
  if(password === '' || password == null){
    errors.push('Password is required')
    password_input.parentElement.classList.add('incorrect')
  }

  return errors;
}

const allInputs = [firstname_input, email_input, password_input, repeat_password_input].filter(input => input != null)

allInputs.forEach(input => {
  input.addEventListener('input', () => {
    if(input.parentElement.classList.contains('incorrect')){
      input.parentElement.classList.remove('incorrect')
      error_message.innerText = ''
    }
  })
})


document.addEventListener("DOMContentLoaded", function () {
  const loginModal = document.getElementById("loginModal");
  const signupModal = document.getElementById("signupModal");
  
  const loginBtn = document.querySelector(".searchToggle i"); // Login button (user icon)
  const signupLink = document.getElementById("switchToSignup"); // "Create Account" link in login modal
  const loginLink = document.getElementById("switchToLogin"); // "Login" link in signup modal
  
  const loginCloseBtn = loginModal.querySelector(".close");
  const signupCloseBtn = signupModal.querySelector(".close");

  // Open login modal
  loginBtn.addEventListener("click", function () {
    loginModal.classList.add("show");
  });

  // Open signup modal and close login modal
  signupLink.addEventListener("click", function (e) {
    e.preventDefault();
    loginModal.classList.remove("show");
    signupModal.classList.add("show");
  });

  // Open login modal and close signup modal
  loginLink.addEventListener("click", function (e) {
    e.preventDefault();
    signupModal.classList.remove("show");
    loginModal.classList.add("show");
  });

  // Close modals
  loginCloseBtn.addEventListener("click", function () {
    loginModal.classList.remove("show");
  });

  signupCloseBtn.addEventListener("click", function () {
    signupModal.classList.remove("show");
  });

  // Close modal when clicking outside
  window.addEventListener("click", function (e) {
    if (e.target === loginModal) {
      loginModal.classList.remove("show");
    }
    if (e.target === signupModal) {
      signupModal.classList.remove("show");
    }
  });
});
