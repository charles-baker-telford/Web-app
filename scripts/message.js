const data = '{"message": [{"type": "message", "content": "This is message 1"},{"type": "confirm", "content": "This is message 2"}]}'; 
    
class Data {
    constructor(name, data) {
        this.name = name
        this.data = JSON.parse(data)
        for (var i in this.data.message) {
            var message = this.data.message[i]
            if (message.type == "warn") {
                var message = new Message_Warn(message)
            } else if (message.type == "error") {
                var message = new Message_Error(message)
            } else if (message.type == "confirm") {
                var message = new Message_Confirm(message)
            } else {
                var message = new Message(message)
            }
        }
        
        
    }
}

class Message {
    constructor(message){
        this.content = message.content
        this.type = message.type
        this.display()
    }

    display() {
        var wrapper = '<div class="popup"><div class="message_type">';
        wrapper += '<img src="images/info.svg">';
        wrapper += '<span class="delete" onclick="this.parentNode.parentNode.remove()">❌</span>';
        wrapper += `</div><p>${this.content}</p></div>`
        document.getElementById("popup-container").innerHTML +=  wrapper 
    }
}
class Message_Warn extends Message {

    display() {
        var wrapper = '<div class="popup"><div class="message_type">';
        wrapper += '<img src="images/warn.svg">';
        wrapper += '<span class="delete" onclick="this.parentNode.parentNode.remove()">❌</span>';
        wrapper += `</div><p>${this.content}</p></div>`
        document.getElementById("popup-container").innerHTML +=  wrapper 
    }
}
class Message_Error extends Message {

    display() {
        var wrapper = '<div class="popup"><div class="message_type">';
        wrapper += '<img src="images/error.svg">';
        wrapper += '<span class="delete" onclick="this.parentNode.parentNode.remove()">❌</span>';
        wrapper += `</div><p>${this.content}</p></div>`
        document.getElementById("popup-container").innerHTML +=  wrapper 
    }
}
class Message_Confirm extends Message {

    display() {
        var wrapper = document.createElement("div");
        wrapper.setAttribute("class", "popup")
        var message_wrapper = document.createElement("div");
        message_wrapper.setAttribute("class", "message_type")
        wrapper.appendChild(message_wrapper);
        var icon = document.createElement("img");
        icon.setAttribute("src", "images/confirm.svg");
        message_wrapper.appendChild(icon);
        var control = document.createElement("span");
        control.setAttribute("class", "delete");
        control.setAttribute("onclick", "this.parentNode.parentNode.remove()")
        control.innerText = "❌"
        message_wrapper.appendChild(control);
        var message = document.createElement("p");
        message.innerText = this.content
        wrapper.appendChild(message)
        var button = document.createElement("button");
        button.innerText = "Confirm";
        button.type = "button"
        button.addEventListener('click', () => {
            console.log('The button was clicked!');
        });
        wrapper.appendChild(button)
        
        
        document.getElementById("popup-container").appendChild(wrapper)
    }
}


var this_response = new Data("something", data)


