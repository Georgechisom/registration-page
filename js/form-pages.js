const email_div = document.querySelector("#emailDiv");
const otp_div = document.querySelector("#otpDiv");
const first_name = document.querySelector("#firstDiv");
const last_name = document.querySelector("#lastDiv");
const phone_number = document.querySelector("#numberDiv");
const expert_div = document.querySelector("#expertiseDiv");
const country_div = document.querySelector("#countryDiv");
const state_div = document.querySelector("#stateDiv");
const school_div = document.querySelector("#schoolDiv");
const volunteer_div = document.querySelector("#volunteerDiv");
const email_btn = document.querySelector(".emailbtn");
const register_btn = document.querySelector(".regbtn");
const otp_btn = document.querySelector(".otpbtn");

email_btn.onclick = () => {
    email_div.style.display = "none"
    otp_div.style.display = "block"
    email_btn.style.display = "none"
    otp_btn.style.display = "block"
}

otp_btn.onclick = () => {
    email_div.style.display = "none"
    otp_div.style.display = "block"
    email_btn.style.display = "none"
    otp_btn.style.display = "block"
}