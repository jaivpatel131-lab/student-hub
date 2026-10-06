document.addEventListener("DOMContentLoaded",()=>{
const lf=document.getElementById("loginForm");
lf?.addEventListener("submit",e=>{e.preventDefault();if(!lf.checkValidity()){lf.classList.add("was-validated");return}const id=document.getElementById("loginId").value.trim(),pw=document.getElementById("loginPassword").value;const reg=JSON.parse(localStorage.getItem("studenthub_profile")||"null");const ok=(id.toLowerCase()==="student@demo.com"&&pw==="student123")||(reg&&(id.toLowerCase()===String(reg.email).toLowerCase()||id===reg.id)&&pw===reg.password);if(ok){localStorage.setItem("studenthub_logged_in","true");toast("Login successful! Welcome back.","success");setTimeout(()=>location.href="dashboard.html",650)}else toast("Invalid demo credentials. Try student@demo.com / student123.","error")});
document.getElementById("forgotLink")?.addEventListener("click",e=>{e.preventDefault();toast("For this front-end demo, use the displayed demo credentials.","info")});
const rf=document.getElementById("registerForm"),pass=document.getElementById("regPassword");
pass?.addEventListener("input",()=>{const v=pass.value,s=document.querySelector(".strength");s.className="strength "+(v.length<6?"weak":v.length<9?"medium":"strong")});
rf?.addEventListener("submit",e=>{
  const pw=document.getElementById("regPassword").value,cp=document.getElementById("regConfirm").value;
  if(pw!==cp){e.preventDefault();toast("Passwords do not match.","error");return}
  if(!rf.checkValidity()){e.preventDefault();rf.classList.add("was-validated");toast("Please correct the highlighted fields.","error");return}
  // Live Server has no PHP runtime, so keep the original local demo workflow.
  if(location.protocol==='file:'){e.preventDefault();saveLocal();return}
  // If using XAMPP/WAMP, native POST reaches register.php as required by Lab 7.
});
function saveLocal(){const p={name:regName.value,id:regId.value,email:regEmail.value,phone:regPhone.value,dob:regDob.value,gender:regGender.value,course:regCourse.value,semester:regSemester.value,address:regAddress.value,password:regPassword.value};localStorage.setItem("studenthub_profile",JSON.stringify(p));toast("Registration saved locally!","success");setTimeout(()=>location.href="login.html",800)}
});
