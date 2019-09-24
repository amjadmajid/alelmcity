var chapter = document.getElementsByClassName('chapter');

for (var i = chapter.length - 1; i >= 0; i--) {
  chapter[i].addEventListener("click", function(e){

    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'http://alelmcity.com/apps/snippet/yourelibrary/private/ajax/find_content_by_chapterid.php?id='+e.id , true);

    xhr.onreadystatechange = function(e){

      console.log( 'readyState:', xhr.readyState);

      if(xhr.readyState == 2){
        e.nextElementSibling.innerHTML ='loading...';
      }
      if(xhr.readyState == 4 && xhr.status ==200){
        e.nextElementSibling.innerHTML = xhr.responseText;
      }
    }
    xhr.send();

  });
}