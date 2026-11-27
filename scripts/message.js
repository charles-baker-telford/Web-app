
    
class Data {
    constructor(name, data) {
        this.name = name
        this.data = data
        for (var i in this.data.messages) {
            var message = this.data.messages[i]
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
        if (this.data.redirect) {
            window.location = this.data.redirect[0].location
        }
        console.log(this.data.status)
        var profile = new profile_data(this.data.data[0].profile[0])
        console.log(this.data.redirect)
        
    }
}
class profile_data {
    constructor(data){
        this.data = data
        for (const [key, value] of Object.entries(data))
            this.add_profile_item(key, value)
        }

   
    add_profile_item(attr, content) {
        const label = document.createElement("label");
        label.htmlFor = attr; // sets the "for" attribute
        label.textContent = attr;

        var span = document.createElement("SPAN");
        span.setAttribute("class", "profile_item");
        span.setAttribute("contenteditable", "True");
        span.setAttribute("id", attr);
        span.textContent = content
        span.addEventListener("blur", async (e) => {
            console.log("target", e.target.id)
            await saveToDatabase(e.target.textContent, e.target.id);
            
        });
        label.appendChild(span);
        document.getElementById("panel").appendChild(label)

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

//var this_response = new Data("something", data)


