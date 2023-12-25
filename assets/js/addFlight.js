function showForm() {
    console.log("addFlight");
    document.getElementById("popup").style.display = "block";
    document.getElementById("popup").style.color = "black";
    document.getElementById("popup").classList.toggle("active");
}

function closeForm() {
    document.getElementById("popup").style.display = "none";
    document.getElementById("popup").classList.toggle("active");
}

function add(){
    var formfield = document.getElementById('destinations');
    var newField = document.createElement('input');
    newField.setAttribute('type','text');
    newField.setAttribute('name','text');
    newField.setAttribute('class','text');
    newField.setAttribute('siz',50);
    newField.setAttribute('placeholder','Add Destination');
    formfield.appendChild(newField);
  }
  
  function remove(){
    var formfield = document.getElementById('destinations');
    var input_tags = formfield.getElementsByTagName('input');
    if(input_tags.length > 1) {
      formfield.removeChild(input_tags[(input_tags.length) - 1]);
    }
  }