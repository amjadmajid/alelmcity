// get access to the element that will hold the output
target = document.getElementById("main");

// get access to the elements that will provide the input 
var elm = document.getElementsByClassName("shelf");
var gShelfId;
var gShelfName;

// Attach an event listener to the input elements (shelf links)
for (var i = elm.length - 1; i >= 0; i--) {
    elm[i].addEventListener("click", function(e){  
    eventHandler(e);
  }, false);
}

  // var eventHandler_access_control = true;
  var sid;
  var bid;
  var cid="";
  var check_book_id;
  var check_shelf_id;
  var check_chapter_id;

var urlParams;
window.onload = function(e){
  urlParams = window.location.search;
  var pat_sid = /sid=\d/g; 
  var pat_bid = /bid=\d/g; 
  var pat_cid = /cid=\d/g; 
  var digi = /\d+/g;
  check_shelf_id = pat_sid.test(urlParams);
  check_book_id = pat_bid.test(urlParams);
  check_chapter_id = pat_cid.test(urlParams);
  if(check_shelf_id){
    sid= urlParams.match(pat_sid).toString();
    sid= sid.match(digi).toString();
    bid= urlParams.match(pat_bid).toString();
    bid= bid.match(digi).toString();
    cid= urlParams.match(pat_cid).toString();
    cid=cid.match(digi).toString();
      // console.log(sid);
    if(sid)
    {
      eventHandler(e);
    }

  }
}

function eventHandler(e)
{
  console.log('eventHandler is called');
  // if( ! eventHandler_access_control){return;}
  // eventHandler_access_control = false;
      // prevent the default behavior of the element when it is clicked 
    e.preventDefault();
      // console.log(e);

    // get the needed information from the href of the cliked element
    // to make Ajax request
    if(e.target.href)
    {
      var url =  new URL(e.target.href);
    }
    else{
      var url =  new URL(e.target.URL);
    }
    var id =  url.searchParams.get('sid');
    var shelfName =  url.searchParams.get('s');
    gShelfId = id;
    console.log("id "+ id);
    gShelfName = shelfName;
    // make an Ajax object
    var xhr = new XMLHttpRequest();
        // start GET request (since we are only fetching data)
        xhr.open('GET', 'http://alelmcity.com/apps/snippet/yourelibrary/private/ajax/getBooksByShelfId.php?id='+ id, true);

        // assign a callback to an anonymous function
        xhr.onreadystatechange = function(){
          if(xhr.readyState == 2){

            //When the data of our request is just begin to arrive 
            //remove `childElements` with `given` class name

            removeUnits(target, 'unit');
            removeUnits(target, 'addNewBook');
            removeUnits(target, 'welcomeString');
          }

          if(xhr.readyState == 4 && xhr.status ==200){
            // When all the data is received do the following

            // get the returned string and make it a JSON object
            var results = JSON.parse(xhr.responseText);
            // console.log(results);
            var booksNames = results.book;
            var booksIds = results.bookid;
            if(booksNames){
              for (var i = 0; i < booksNames.length ; i++) {
                // Create a unit element and appended it to the element with id of `main`
                var bookElem = appendUnit(target,  booksNames[i],  booksIds[i]);
                // this function is in another file
                // this function will make a new Ajax request for each book
                // to get its content
                //// Go to getChaptersByBookId.js file
                // console.log("bookElem, booksNames[i], booksIds[i], cid"+ bookElem + booksNames[i] + booksIds[i] + cid);
                addChaptersByBookId(bookElem, booksNames[i], booksIds[i]);
                // attach and event listener to the book element to show/hide the chapters
                addToggleChaptersEvent(bookElem);
                // if(check_book_id){
                //   // click on the book after returning from editting

                //   console.log("bid " + bid);
                //   document.getElementById(bid).click();
                // }
              }
            }
            // append the new book link after all units have been appended
            newBookLink(shelfName, id);

            // eventHandler_access_control = true;

          }
        }
        xhr.send();

        // clear the url
        window.history.replaceState(null, null, window.location.pathname);
}

function appendUnit(target, bookName, bookId){
  //1- create the unit node
  var unit = document.createElement('div');
  unit.className = "unit";

  //2- create the book div
   var book = document.createElement('a');
   book.alt ="Book"
   book.className = "book";
   // Adding the letter b to differentiate between the books ids and the chapters ids 
   book.id = "b"+bookId;

   //3- create the text node
   var bookNameElm =  document.createTextNode(bookName);
   book.appendChild(bookNameElm);

   editBookLink(book, bookName, bookId);
   delBookLink(book, bookName, bookId);

   unit.appendChild(book);
   target.appendChild(unit);
   return book;
}


function removeUnits(target, child){

    function removeUnit(u){
    target.removeChild(u); 
  }

  var childs = document.getElementsByClassName(child);
  for (var i = childs.length - 1; i >= 0; i--) {
    removeUnit(childs[i]);
  }
}


function addToggleChaptersEvent(book){

      book.addEventListener("click", function() {
          book.parentNode.classList.toggle("showChapter");
          book.parentNode.classList.toggle("showNewChapter");
          book.parentNode.classList.toggle("borderShow");
          }, false); // function is finished

      // book.addEventListener("touchstart", function() {
      //     book.parentNode.classList.toggle("showChapter");
      //     book.parentNode.classList.toggle("showNewChapter");
      //     book.parentNode.classList.toggle("borderShow");
      //     }, false); // function is finished
}



// Create the new book link
function newBookLink(shelf, id){
  var createBookLink = document.createElement('a');
  var textNode = document.createTextNode("Add Book");
  createBookLink.href="protected/new.php?sid="+id+"&s="+shelf;
  createBookLink.appendChild(textNode);
  createBookLink.className="addNewBook";
  document.getElementById("main").appendChild(createBookLink);
}

// Create the edit chapter link
function editBookLink(bookElm, bookName, bookId){
  var createEditBookLink = document.createElement('a');
  // var textNode = document.createTextNode("&#9998;");
  createEditBookLink.href="protected/edit.php?bid="+bookId+"&b="+bookName+
  "&sid="+gShelfId+"&s="+gShelfName;
  // createEditBookLink.appendChild(textNode);
  createEditBookLink.innerHTML= "&#9998;";
  createEditBookLink.className="edit";
  bookElm.appendChild(createEditBookLink);
}

// Create the edit chapter link
function delBookLink(bookElm, bookName, bookId){
  var createEditBookLink = document.createElement('a');
  // var textNode = document.createTextNode("&#9998;");
  createEditBookLink.href="protected/delete.php?bid="+bookId+"&b="+bookName+
  "&sid="+gShelfId+"&s="+gShelfName;
  // createEditBookLink.appendChild(textNode);
  createEditBookLink.innerHTML= "&#10008;";
  createEditBookLink.className="del";
  bookElm.appendChild(createEditBookLink);
}
