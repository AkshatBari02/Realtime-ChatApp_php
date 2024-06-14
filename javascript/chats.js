const form = document.querySelector(".typing-area"),
inputField = form.querySelector(".input-field"),
sendBtn = form.querySelector("button"),
chatBox = document.querySelector(".chat-box");


form.onsubmit = (e)=>{
    e.preventDefault();
}


sendBtn.onclick = () =>{
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/insert-chats.php", true);
    xhr.onload = () =>{
        if(xhr.readyState === XMLHttpRequest.DONE){
            if(xhr.status === 200){
                inputField.value = ""; //once the message is inserted into DB then leave the message box empty
                scrollToBottom();
            }
        }
    }
    // we have to send the form data from ajax to php
    let formData = new FormData(form); //creating new formData object
    xhr.send(formData); //sending the form data to php
}

chatBox.onmouseenter = ()=>{
    chatBox.classList.add("active"); //when the mouse is on the chat box then add the active class to the chat box
}
chatBox.onmouseleave = ()=>{
    chatBox.classList.remove("active"); //when the mouse is not on the chat box then remove the active class from the chat box
}

setInterval(() =>{
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/get-chats.php", true);
    xhr.onload = () =>{
        if(xhr.readyState === XMLHttpRequest.DONE){
            if(xhr.status === 200){
                let data = xhr.response;
                chatBox.innerHTML=data;
                if(!chatBox.classList.contains("active")){
                    scrollToBottom();
                }
            }
        }
    }
    let formData = new FormData(form); //creating new formData object
    xhr.send(formData); //sending the form data to php
},500); //this function will be called after every 500ms

function scrollToBottom(){
    chatBox.scrollTop = chatBox.scrollHeight;
}