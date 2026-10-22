const data = '{"message": {"type": "error", "content": "This is a test message created from a JSON string"}}'; 
    
class Data {
    constructor(name, data) {
        this.name = name
        this.data = JSON.parse(data)
        var message = this.data.message
        if (message.type == "warn") {
            var message = new Message_Warn(message)
        } else if (message.type == "error") {
            var message = new Message_Error(message)
        } else {
            var message = new Message(message)
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
        document.getElementsByTagName("body")[0].innerHTML +=  wrapper 
    }
}
class Message_Warn extends Message {

    display() {
        var wrapper = '<div class="popup"><div class="message_type">';
        wrapper += '<img src="images/warn.svg">';
        wrapper += '<span class="delete" onclick="this.parentNode.parentNode.remove()">❌</span>';
        wrapper += `</div><p>${this.content}</p></div>`
        document.getElementsByTagName("body")[0].innerHTML +=  wrapper 
    }
}
class Message_Error extends Message {

    display() {
        var wrapper = '<div class="popup"><div class="message_type">';
        wrapper += '<img src="images/error.svg">';
        wrapper += '<span class="delete" onclick="this.parentNode.parentNode.remove()">❌</span>';
        wrapper += `</div><p>${this.content}</p></div>`
        document.getElementsByTagName("body")[0].innerHTML +=  wrapper 
    }
}

var this_response = new Data("something", data)

