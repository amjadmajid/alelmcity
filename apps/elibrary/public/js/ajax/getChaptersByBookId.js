function addChaptersByBookId(bookElm, bookName, BookId){

  var xhr = new XMLHttpRequest();
  xhr.open('GET', 'http://alelmcity.com/apps/snippet/yourelibrary/private/ajax/getChaptersByBookId.php?id='+ BookId, true);

  xhr.onreadystatechange = function(){
    if(xhr.readyState == 4 && xhr.status ==200){

      var chapters = xhr.responseText;
          // console.log('chapters'+chapters);
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

      for (var cntr = 0; cntr < chaptersNames.length ; cntr++) {
       var chapter = elementMaker(bookElm, 'div',chaptersNames[cntr],chaptersIds[cntr], 'chapter' );
       showHideContent(chapter);
       editChapterLink(bookName, BookId, chapter,chaptersNames[cntr], chaptersIds[cntr]);
       delChapterLink(bookName, BookId, chapter,chaptersNames[cntr], chaptersIds[cntr]);
       var content = elementMaker(bookElm, 'div', chaptersContents[cntr],"", 'content');
     }

     if(check_book_id && (BookId == bid) )
     {
        // click on the book after returning from editting

        console.log("bid " + bid);
        document.getElementById("b"+bid).click();

        // console.log('cid', cid)
        if(check_chapter_id && (chaptersIds[cntr] == cid) )
        {
          document.getElementById(cid).click();
        }

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
      chapter.addEventListener("click", function() {
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
  createEditChapterLink.innerHTML= "&#9998;";
  createEditChapterLink.className="editChapter";
  chapterElm.appendChild(createEditChapterLink);
}

// Create the edit chapter link
function delChapterLink(bookName, bookId, chapterElm, chapterName, chapterId){
  var createEditChapterLink = document.createElement('a');
  // var textNode = document.createTextNode("&#9998;");
  createEditChapterLink.href="protected/delete.php?cid="+chapterId+"&c="+chapterName+"&bid="+bookId+"&b="+bookName+
  "&sid="+gShelfId+"&s="+gShelfName;
  // createEditChapterLink.appendChild(textNode);
  createEditChapterLink.innerHTML= "&#10008;";
  createEditChapterLink.className="del";
  chapterElm.appendChild(createEditChapterLink);
}






