function addChaptersByBookId(bookElm, bookName, BookId){

  var xhr = new XMLHttpRequest();
      xhr.open('GET', 'http://alelmcity.com/apps/snippet/yourelibrary/private/ajax/getChaptersByBookId.php?id='+ BookId, true);

      xhr.onreadystatechange = function(){
        if(xhr.readyState == 4 && xhr.status ==200){

          var chapters = xhr.responseText;
          console.log(chapters);
          appendChaptersToBook(bookElm,bookName, BookId ,JSON.parse(chapters));
        }
      }
      xhr.send();
}


function appendChaptersToBook(bookElm, bookName, BookId,  bookContent){
    
    // console.log('bookContent', bookContent);

    if(bookContent.chaptersnames){
      var chaptersNames = bookContent.chaptersnames;
      var chaptersContents = bookContent.chapterscontents;
      var chaptersIds = bookContent.chaptersids;

      for (var i = chaptersNames.length - 1; i >= 0; i--) {
         var chapter = elementMaker(bookElm, 'div',chaptersNames[i],chaptersIds[i], 'chapter' );
        showHideContent(chapter);
        editChapterLink(bookName, BookId, chapter,chaptersNames[i], chaptersIds[i]);
        var content = elementMaker(bookElm, 'div', chaptersContents[i],"", 'content');
      }
    }
      // append the link to create a new chapter, 
      newChapterLink(bookElm,bookName, BookId);
}
function elementMaker(parent, type="", text="", id="", classname=""){
     // var textNode = document.createTextNode(text);
      var elm = document.createElement(type);
      // elm.appendChild(textNode);
      elm.innerHTML = text;
      elm.className = classname;
      if(id) elm.id = id;
      parent.parentNode.appendChild(elm);
      return elm;
}

function showHideContent(chapter){
  chapter.addEventListener("mousedown", function() {
      chapter.nextElementSibling.classList.toggle("showContent");
      }); // function is finished
}

// Create the new book link
function newChapterLink(bookElm, bookName, BookId){
  var createNewChapterLink = document.createElement('a');
  var textNode = document.createTextNode("Add Chapter");
  createNewChapterLink.href="protected/new.php?bid="+BookId+"&b="+bookName+"&sid="+gShelfId+"&s="+gShelfName;
  createNewChapterLink.appendChild(textNode);
  createNewChapterLink.className="addNewChapter";
  bookElm.parentNode.appendChild(createNewChapterLink);
}

// Create the edit chapter link
function editChapterLink(bookName, bookId, chapterElm, chapterName, chapterId){
  var createEditChapterLink = document.createElement('a');
  // var textNode = document.createTextNode("&#9998;");
  createEditChapterLink.href="protected/edit.php?cid="+chapterId+"&c="+chapterName+"&bid="+bookId+"&b="+bookName+
  "&sid="+gShelfId+"&s="+gShelfName;
  // createEditChapterLink.appendChild(textNode);
  createEditChapterLink.innerHTML= "&#9998;"
  createEditChapterLink.className="editChapter";
  chapterElm.appendChild(createEditChapterLink);
}






