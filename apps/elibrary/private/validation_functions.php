<?php
	function is_blank($string){
		// check if a string is empty 
		// is_blank return true on: "", " ", false
		return (!isset($string) || trim($string) ==='');
	}

	  function has_valid_email_format($value) {
    $email_regex = '/\A[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}\Z/i';
    return preg_match($email_regex, $value) === 1;
  }

	function passwords_match($s1, $s2){
		return ($s1 == $s2);
	}

	function fatal_insertion_error($shelf, $book, $chapter){
		return ( is_blank($shelf) || ( is_blank($book) && !is_blank($chapter) ) );
	}
?>