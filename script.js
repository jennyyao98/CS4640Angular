// <!-- Selinie Wang (jw6qe), Helen Lin (hl5ec), Jenny Yao (jy7eq) -->
function change(){
    var card = document.querySelector('.card');
    var saveButton = document.getElementById("saveBtn");
    console.log(card.style);
    if (saveBtn.value =="Save"){
        saveBtn.value = "Saved!";
        saveBtn.style.backgroundColor = "#c71a2e";
        card.style.boxShadow = "10px 10px 25px -3px rgba(255,66,88,0.1)";

    }
    else{
        saveBtn.value = "Save";
        saveBtn.style.backgroundColor = "#FF4258";
        card.style.boxShadow = "10px 10px 25px -3px rgba(0,0,0,0.1)";
    }
    }
