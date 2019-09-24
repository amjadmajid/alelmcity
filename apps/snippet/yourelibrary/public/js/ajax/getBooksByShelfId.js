// get access to the element that will hold the output
target = document.getElementById("main");

// get access to the elements that will provide the input 
var elm = document.getElementsByClassName("shelf");
var gShelfId;
var gShelfName;

// Attach an event listener to the input elements (shelf links)
for (var i = elm.length - 1; i >= 0; i--) {
    elm[i].addEventListener("click", function(e){  
    
    // prevent the default behavior of the element when it is clicked 
    e.preventDefault();

    // get the needed information from the href of the cliked element
    // to make Ajax request
    var url =  new URL(this.href);
    var id =  url.searchParams.get('sid');
    var shelfName =  url.searchParams.get('s');
    gShelfId = id;
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
            var booksNames = results.book;
            var booksIds = results.bookid;
            if(booksNames){
              for (var i =  booksNames.length - 1; i >= 0; i--) {
                // Create a unit element and appended it to the element with id of `main`
                var bookElem = appendUnit(target,  booksNames[i]);
                // this function is in another file
                // this function will make a new Ajax request for each book
                // to get its content
                //// Go to getChaptersByBookId.js file
                addChaptersByBookId(bookElem, booksNames[i], booksIds[i]);
                // attach and event listener to the book element to show/hide the chapters
                addToggleChaptersEvent(bookElem);
              }
            }
            // append the new book link after all units have been appended
            newBookLink(shelfName, id);
          }
        }
        xhr.send();
  }, false);
}


function appendUnit(target, bookName){
  //1- create the unit node
  var unit = document.createElement('div');
  unit.className = "unit";

  //2- create the book div
   var book = document.createElement('a');
   book.alt ="Book"
   book.className = "book";

   //3- create the text node
   var bookName =  document.createTextNode(bookName);
   book.appendChild(bookName);
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

