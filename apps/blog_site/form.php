<form method='post' class='comments' id='addComments'>
        <input type="hidden" value="" id="category_id" name="category_id" />
        <input type="text" value="" id="name" name="name" placeholder="Your Name" required="" />
        <input type="email" value="" id="email" name="email" placeholder="Your Email (for validation)" required="" />
        <input type="text" value="" id="title" name="title" placeholder="Title" required="" />
        <textarea maxlength="500" id="comments" name="comments" required="" placeholder="Your Comment / QA (will be moderated)"></textarea>
        <input type='button' id='submited' onmouseup='mouseup();'
        onmousedown='mousedown()' value="Submit" />
</form>