/**
 * Functions returns new XMLHttpRequest.
 * @returns {*}
 */
function getXMLHttpRequest(){
    if(window.XMLHttpRequest){
        try{
            return new XMLHttpRequest();
        }catch(e){
            alert('Error ' + e.name + ":" + e.message);
        }
    }else if(window.ActiveXObject){
        try{
            return new ActiveXObject("Microsoft.XMLHTTP");
        }catch(e){
            alert('Error ' + e.name + ":" + e.message);
        }
        try{
            return new ActiveXObject("Msxml2.XMLHTTP");
        }catch(e){
            alert('Error ' + e.name + ":" + e.message);
        }
    }
}

/**
 * Function to create new news item via XMLHttpRequest
 */
function createItem(){
    var body = "title=" + title.value +
        "&date=" + date.value +
        "&text=" + text.value +
        "&id=" + id.value;
    var url = "/index.php?r=create-news-ajax";
    changeItem(url, body);
}

/**
 * Function to edit news item via XMLHttpRequest
 */
function updateItem(){
    var body = "title=" + title.value +
        "&date=" + date.value +
        "&text=" + text.value +
        "&id=" + id.value;
    var url = "/index.php?r=edit-news-ajax&id=" + id.value;
    changeItem(url, body);
}

/**
 * Function is used in createItem() and updateItem() functions
 * to create/edit news item via XMLHttpRequest
 */
function changeItem(url, body){
    var request = getXMLHttpRequest();
    request.onreadystatechange = function(){
        if(request.readyState != 4) return false;
        if(request.status != 200){
            alert("Something happened: " + request.statusText);
        }
        var notifyBlock = document.getElementsByClassName('notify')[0];
        var reg = /^[0-3]{1,1}[0-9]{1,1}.[0-1]{1,1}[0-9]{1,1}.[0-9]{1,4}$/;
        if(request.responseText != 'Item was created!' && request.responseText != 'Changes saved!'){
            notifyBlock.style.backgroundColor = '#D85252';
            notifyBlock.firstChild.firstChild.nodeValue = request.responseText;
        }else if(!reg.test(date.value)){
            notifyBlock.style.backgroundColor = '#D85252';
            notifyBlock.firstChild.firstChild.nodeValue = 'Wrong date format!';
        }else{
            notifyBlock.style.backgroundColor = '';
            notifyBlock.firstChild.firstChild.nodeValue = request.responseText;
        }

        //Show notification message on 2,8 seconds
        notifyBlock.style.display = 'block';
        setTimeout(function(){notifyBlock.style.display = 'none';}, 2800);

        //Show back2list button
        var back2ListBtn = document.getElementById('back-2-list');
        back2ListBtn.style.display = 'block';
    };
    request.open("POST", url, true);
    request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    request.send(body);
}

/**
 * Function is used to add comment via XMLHttpRequest to view single news item page.
 */
function addComment(){
    var body = "thename=" + thename.value +
        "&email=" + email.value +
        "&comment=" + comment.value +
        "&itemid=" + itemid.value;
    var url = "/index.php?r=add-comment-ajax&id=" + itemid.value;
    var request = getXMLHttpRequest();
    request.onreadystatechange = function(){
        if(request.readyState != 4) return false;
        if(request.status != 200){
            alert("Something happened: " + request.statusText);
        }
        var commentsList = document.getElementsByClassName('comments-list')[0];

        var notifyBlock = document.getElementsByClassName('notify')[0];
        if(request.responseText != 'Your comment was added!'){
            notifyBlock.style.backgroundColor = '#D85252';
            notifyBlock.firstChild.firstChild.nodeValue = request.responseText;
        }else if(email.value !='' && !validateEmail(email.value)){
            notifyBlock.firstChild.firstChild.nodeValue = 'Check your email';
            notifyBlock.style.backgroundColor = '#D85252';
        }else{
            notifyBlock.style.backgroundColor = '';
            notifyBlock.firstChild.firstChild.nodeValue = request.responseText;

            // Add new comment item to list via AJAX
            var newSection =  document.createElement('section');
            var today = new Date();
            var sectionInner = '<h5>' + thename.value + '<span> says...' + '</span></h5>';
            sectionInner += '<p>' + comment.value + '</p>';
            sectionInner += '<div class="comment-date">' +
                today.getDate() + '.' +
                today.getMonth() + 1 + '.' +
                today.getFullYear()
                + '</div>';
            newSection.innerHTML = sectionInner;
            commentsList.insertBefore(newSection, commentsList.children[1]);

            //Reset form after successful adding new comment
            document.getElementById('comment-form').reset();
        }
        notifyBlock.style.display = 'block';
        setTimeout(function(){notifyBlock.style.display = 'none';}, 2800);
    };
    request.open("POST", url, true);
    request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    request.send(body);
}

/**
 * Function to validate email.
 */
function validateEmail(email){
    var re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

/**
 * Function to remove news item.
 */
function deleteItem(id){
    if(!confirm('Are you sure, you want to delete this item?')) return false;
    var url = "/index.php?r=delete-news-ajax&id=" + id;
    var request = getXMLHttpRequest();
    request.onreadystatechange = function(){
        if(request.readyState != 4) return false;
        if(request.status != 200){
            alert("Something happened: " + request.statusText);
        }
        var item2delete =  document.getElementById(id);
        while (item2delete.firstChild) {
            item2delete.removeChild(item2delete.firstChild);
        }
        item2delete.remove();
    };
    request.open("GET", url, true);
    request.send(null);
}