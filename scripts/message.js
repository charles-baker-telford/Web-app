var data = '{"message": [{"type": "message", "content": "This is a default message"},{"type": "confirm", "content": "This is a confirm message"},'
data += '{"type": "warn", "content": "This is warn message"},{"type": "error", "content": "This is an error message"}'; 
data += ']}';
    
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
        var wrapper = get_message_container(this.content)
        document.getElementById("popup-container").appendChild(wrapper)
    }
}
class Message_Warn extends Message {

    display() {
        var wrapper = get_message_container(this.content)
        wrapper.querySelector("img").src = "images/warn.svg"
        
        document.getElementById("popup-container").appendChild(wrapper)
    }
}
class Message_Error extends Message {

    display() {
        var wrapper = get_message_container(this.content)
        wrapper.querySelector("img").src = "images/error.svg"
        
        document.getElementById("popup-container").appendChild(wrapper)
    }
}
class Message_Confirm extends Message {

    display() {
        var wrapper = get_message_container(this.content)
        wrapper.querySelector("img").src = "images/confirm.svg"
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

function get_message_container(message_text) {
    var wrapper = document.createElement("div");
        wrapper.setAttribute("class", "popup")
        var message_wrapper = document.createElement("div");
        message_wrapper.setAttribute("class", "message_type")
        wrapper.appendChild(message_wrapper);
        var icon = document.createElement("img");
        icon.setAttribute("src", "images/info.svg");
        message_wrapper.appendChild(icon);
        var control = document.createElement("span");
        control.setAttribute("class", "delete");
        control.setAttribute("onclick", "this.parentNode.parentNode.remove()")
        control.innerText = "❌"
        message_wrapper.appendChild(control);
        var message = document.createElement("p");
        message.innerText = message_text
        wrapper.appendChild(message)

        return wrapper;
}

var this_response = new Data("something", data)


