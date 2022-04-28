function twoReceptionist(location){
    return true;
}

function isOldEnough(){
    var x = document.getElementById(divName);
    if(x.value>="2007-12-31"){
        showExtraFields(underage);
    }
}

function showExtraFields(divName){
    var x = document.getElementById(divName);
    x.removeAttribute("hidden");
}

function hideExtraFields(divName){  
    var x = document.getElementById(divName);
    x.setAttribute("hidden");
}

function calculateAge(dob){
    var today = new Date();
    var birthDate = new Date(dob);
    var age = today.getFullYear() - birthDate.getFullYear();
    var m = today.getMonth() - birthDate.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }
    return age;
}

function getRandomNumberBetween(){
    return Math.floor(Math.random()*(1000000-0+1)+0);
}

function getUserType(){
    var e = document.getElementById("user_type");
    return e.value;
    
}