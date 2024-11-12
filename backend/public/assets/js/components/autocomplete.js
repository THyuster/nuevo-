$("#autocompleteInput").autocomplete({ 
    source: function(request, response) {
        var results = $.ui.autocomplete.filter(src, request.term);
        
        response(results.slice(0, 10));
    }
});

var src = [
    "ActionScript",
    "AppleScript",
    "Asp",
    "BASIC",
    "C",
    "C++",
    "Clojure",
    "COBOL",
    "ColdFusion",
    "Erlang",
    "Fortran",
    "Groovy",
    "Haskell",
    "Java",
    "JavaScript",
    "Lisp",
    "Perl",
    "PHP",
    "Python",
    "Ruby",
    "Scala",
    "Scheme"];