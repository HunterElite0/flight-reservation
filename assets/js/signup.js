function showCompany(){
    document.getElementById('company-div').style.display ='block';
    document.getElementById('passenger-div').style.display ='none';
    document.getElementById('company-div').getElementsByTagName('textarea').required = true;
    for (let i = 0; i < 4; i++) {
        document.getElementById('company-div').getElementsByTagName('input')[i].required = true;
    }
    for (let i = 0; i < 2; i++) {
        document.getElementById('passenger-div').getElementsByTagName('input')[i].required = false;
    }
}

function showPassenger(){
    document.getElementById('company-div').style.display ='none';
    document.getElementById('passenger-div').style.display ='block';
    document.getElementById('company-div').getElementsByTagName('textarea').required = false;
    for (let i = 0; i < 4; i++) {
        document.getElementById('company-div').getElementsByTagName('input')[i].required = false;
    }
    for (let i = 0; i < 2; i++) {
        document.getElementById('passenger-div').getElementsByTagName('input')[i].required = true;
    }
}