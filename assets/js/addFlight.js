function showForm(num="") {
    console.log("addFlight");
    document.getElementById("popup"+num).style.display = "block";
    document.getElementById("popup"+num).style.color = "black";

    document.getElementById("popup"+num).classList.toggle("active");

    document.getElementById("main").style.filter = "blur(5px)";
    document.getElementById("main").style.transition = "all 0.5s ease";
    
    document.getElementById("main").style.pointerEvents = "none";
}

function closeForm(num="") {
    document.getElementById("popup"+num).style.display = "none";

    document.getElementById("popup"+num).classList.toggle("active");
      
    document.getElementById("main").style.filter = "";

    document.getElementById("main").style.pointerEvents = "auto";
}

function add(){
    var formfield = document.getElementById('destinations');
    var newField = document.createElement('input');
    newField.setAttribute('type','text');
    newField.setAttribute('name','flight-destination[]');
    newField.setAttribute('siz',50);
    newField.setAttribute('placeholder','Add Destination');
    formfield.appendChild(newField);
    var newField2 = document.createElement('input');
    newField2.setAttribute('type','text');
    newField2.setAttribute('name','flight-depart[]');
    newField2.setAttribute('siz',50);
    newField2.setAttribute('onfocus','(this.type="datetime-local")');
    newField2.setAttribute('onblur', '(this.type="text")');
    newField2.setAttribute('placeholder','Flight Departure Time');
    formfield.appendChild(newField2);
    var newField3 = document.createElement('input');
    newField3.setAttribute('type','text');
    newField3.setAttribute('name','flight-arrival[]');
    newField3.setAttribute('siz',50);
    newField3.setAttribute('onfocus','(this.type="datetime-local")');
    newField3.setAttribute('onblur', '(this.type="text")');
    newField3.setAttribute('placeholder','Flight Arrival Time');
    formfield.appendChild(newField3);
  }
  
  function remove(){
    var formfield = document.getElementById('destinations');
    var input_tags = formfield.getElementsByTagName('input');
    if(input_tags.length > 3) {
      formfield.removeChild(input_tags[(input_tags.length) - 1]);
      formfield.removeChild(input_tags[(input_tags.length) - 1]);
      formfield.removeChild(input_tags[(input_tags.length) - 1]);
    }
  }
