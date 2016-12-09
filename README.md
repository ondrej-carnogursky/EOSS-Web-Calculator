# EOSS Web Calculator

At first I need to say, that I have never-ever program web application. The desktop is my ground and last years the C#, dotNet and WPF are my favourite technologies. Simply said, I'm too old for learning something so huge, as the Web is.

But with `EOSS` everything works like a charm. It's lightweight and simple, all you need is:

- copy `libs` and `assets` folders from [EOSS github repositary](https://github.com/Durisvk/EOSS2) to you root web folder
- copy `index.php` from the same repository to root
- create `temp` and `app` folder there
- copy `cofig.eoss` from repository to `app` folder
- add at least two folders to `app` folder (default is `controller` and `view`, but you can override this in `config.eoss`)
- add your own php controllers and html/php views to last two mentioned above (optionally you can create and fill-in `model` folder for a greater app)

And love to programming, because you need to write some handlers in php controller/model files, which has C-like syntax.

Of course, you can simply copy whole folder's hierarchy from repositary, where you can find `\app\controllers\indexEOSS.php` and `app\views\indexView.php` ready to use. Here is how it looks like:

![Folders](https://github.com/ondrej11/EOSS-Web-Calculator/blob/master/Folders.jpg)

Notice an empty `temp` folder, this is the place where `EOSS` (re)generates all necessary magic when some user loads your app. Then it can look like this:

![Folders](https://github.com/ondrej11/EOSS-Web-Calculator/blob/master/Temp.jpg)

You can also notice, that your app url doesn't change anyway, everything is working through AJAX and `EOSS` sessions registry system. Great!

Ok, now let's look into the Calculator code, the way of work is simply straightforward according to the EOSS documentation. I started with html view `app\view\indexView.html`:

```html
<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>How to program web application by EOSS without JavaScript...</title>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="assets/css/style.css">
        <script src="assets/js/flashes.js"></script>
        <style type="text/css">
            td
            {
                width:50px;
                height:50px;
            }
            input[type=button] {
                height:100%;
                width:100%;
                background-color:darkgrey;
            }
            .operation
            {
                background-color: greenyellow!important;           
                font-size:larger;
            }
        </style>
    </head>
    <body id="calc" style="height: 282px; width: 219px;">
        <div>How to program web application by EOSS without JavaScript:</div>
        <div style="border: thick inset brown; background-color:burlywood">
            <div id="display" style="padding: 4px;height: 42px; text-align: right; font-size: x-large; font-weight: 700; border:1px solid black; background-color: #00FFFF;">
                0</div>
            <table style="width: 100%; height: 56%;">
                <tr>
                    <td><input data-group="b" type="button" value="7" /></td>
                    <td><input data-group="b" type="button" value="8" /></td>
                    <td><input data-group="b" type="button" value="9" /></td>
                    <td><input data-group="o" type="button" value="+" class="operation" /></td>
                </tr>
                <tr>
                    <td><input data-group="b" type="button" value="4" /></td>
                    <td><input data-group="b" type="button" value="5" /></td>
                    <td><input data-group="b" type="button" value="6" /></td>
                    <td><input data-group="o" type="button" value="-" class="operation" /></td>
                </tr>
                <tr>
                    <td><input data-group="b" type="button" value="1" /></td>
                    <td><input data-group="b" type="button" value="2" /></td>
                    <td><input data-group="b" type="button" value="3" /></td>
                    <td><input data-group="o" type="button" value="*" class="operation" /></td>
                </tr>
                <tr>
                    <td><input data-group="b" type="button" value="0" /></td>
                    <td><input data-group="b" type="button" value="." /></td>
                    <td><input data-group="o" type="button" value="+/-" class="operation" /></td>
                    <td><input data-group="o" type="button" value="/" class="operation" /></td>
                </tr>
                <tr height="40px">
                    <td><input id="bc" type="button" value="C" class="operation" style="background-color:deeppink!important" /></td>
                    <td><input id="bce" type="button" value="CE" class="operation" style="background-color:darkorange!important" /></td>
                    <td colspan="2"><input id="result" type="button" value="=" style="background-color:lightseagreen; font-weight:bold; font-size:large" /></td>
                </tr>
            </table>
        </div>
        <button id="flash" style="width:100%">Look here for next features...</button>
        <div id="flashes" data-ignore="true" style="position:relative;width:100%;left:0;margin-left:0"></div>  
    </body>
</html>
```

Simple page with twenty buttons and one `div` tag for displaing the result, all aligned in old good table with some simple styling through CSS and inline styles.
What is important is **id** for `=` , `C` and `CE` buttons and **data-group** attribute for digit buttons 0-9 and operator buttons `+` , `-` , `*` , `/` , including `+/-` for negation. 
At the end I added a button and div for fresh new flashing popup feature of EOSS, but every day a new great features are occuring, so I'll try them later on new version of this simple Calculator. For now I only mention up-to-date features of `EOSS`:

- **Registry** for global static repository support
- **Database** for simple read/write from/to databasies
- **Intervals** for timer-like support
- **Forms** to simplify web forms using
- **Templating** for web templates support
- **DataBinding** a great feature for binding view's elements attributes or view-model one/two way properties binding
- **Services** for web service support
- **Dependancy Injection** for modern DI pattern support

...

Ok, back to the Calculator. The `app\controller\IndexEOSS.php` was for me even simplier than the view. I need only declare 3 variables for calc-state, connect to view in EOSS inherited **load** method and bind view's elements events to my 5 handlers in second inherited method **bind**:

```php
<?php

use EOSS\EOSS;

class indexEOSS extends EOSS
{
    public $number = NULL; //last number
    public $operator = NULL; //last operator
    public $newNumber = true; //starting new number input indicator

    public function load()
    {
        //connect to View
        $this->csi->setFile("indexView.html");
    }

    public function bind()
    {
        //bind to common event handler by data-group html tag
        $this->csi->b->onclick[] = "writeToDisplay";
        $this->csi->o->onclick[] = "onOperator";
        //bind to event handler by id
        $this->csi->bc->onclick[] = "clearAll";
        $this->csi->bce->onclick[] = "clearLast";
        $this->csi->result->onclick[] = "evaluate";

```

and the Calculator was ready to publish and work in browser using the mouse.
You could check the handler's methods code here, not something complicated:

```php
    public function writeToDisplay($sender,$number=-1) //use -1 instead of NULL or "" due to php implicit conversion of "0"
    {
        if($this->newNumber)
        {
            $this->csi->display->html = $number != -1 ? $number : $sender->value;
            $this->newNumber = false;
        }
        else
            $this->csi->display->html .=  $number != -1 ? $number : $sender->value;
    }

    public function onOperator($sender,$op=NULL)
    {
        $op = $op? : $sender->value;
        switch($op)
        {
            case "+/-":
                $this->csi->display->html = -$this->csi->display->html; break; //"+/-" is not a real operator on two operands
            default:
                if(!$this->newNumber && $this->operator!=NULL)
                    $this->evaluate();
                $this->number = $this->csi->display->html;
                $this->operator = $op;
                $this->newNumber = true;
        }
    }

    public function clearAll()
    {
        $this->csi->display->html = "0";
        $this->newNumber = true;
    }

    public function clearLast()
    {
            $this->csi->display->html = substr($this->csi->display->html,0,-1);
            if(substr($this->csi->display->html,-1)==".")
                $this->csi->display->html = substr($this->csi->display->html,0,-1);
            if($this->csi->display->html == 0)
                $this->csi->display->html = "0"; //replacing empty display with zero
    }

    public function evaluate()
    {
        switch($this->operator)
        {
            case "+":
                $this->csi->display->html += $this->number; break;
            case "-":
                $this->csi->display->html = $this->number - $this->csi->display->html; break;
            case "*":
                $this->csi->display->html *= $this->number; break;
            case "/":
                $this->csi->display->html = $this->number / $this->csi->display->html; break;
        }
        $this->newNumber = true; //prepare to start a new operand number
    }

```

Awesome! Something like code-behind in my lovely WPF or in old Forms,C++ MFC etc (ASP without ASP-server:). Of course, you could explode this feature to models and partial views.

What is important: you got also a `$sender` argument for applying one event handler on grouped elements.

An optional `$number` and `$op` arguments in first two common handlers are there due to the keyboard support, which I added later. Because the `EOSS` not supported the needed events yet, I simply added them to `libs\EOSS\eventList.json` according to the documentation:

```json
  "onkeypressunicode": "keypress:charCode",
  "onkeydown": "keydown:keyCode"
```

and then I could simply connect two new handlers for keyboard events support:

```php
    public function bind()
    {
.
.
.
        //bind to custom keyboard events, added to libs/EOSS/eventList.json
        $this->csi->calc->onkeypressunicode[] = "keyPressed";
        $this->csi->calc->onkeydown[] = "keyDown";
    }
.
.
.
    public function keyPressed($sender, $charCode)
    {
        if($charCode>47 && $charCode<58)
            $this->writeToDisplay(NULL,$charCode - 48); //keys 0-9 pressed
        else
            switch($charCode)
            {
                case 46:
                    $this->writeToDisplay(NULL,"."); break; //decimal digits separator, can be extended by "locale" php function 
                case 42:
                case 43:
                case 45:
                case 47:
                    $this->onOperator(NULL,chr($charCode)); break; // "+-*/" chars used
                case 61:
                    $this->evaluate(); // "=" char used for evaluate
                    break;
            }
    }

    public function keyDown($sender, $keyCode) //needed for special keyboard buttons
    {
        switch($keyCode)
        {
            case 8:
                $this->clearLast(); break; // backspace
            case 27:
                $this->clearAll(); break; // escape
        }
    }

```

At last I tried `flashes` feature of `EOSS`, so added a little bit of code:

```php
    public function bind()
    {
.
.
.
        //display EOSS flash popup
        $this->csi->flash->onclick[] = "flash";
    }
.
.
.
    public function flash()
    {
        $this->flashMessage("Next I will try here some advanced features of EOSS (Register, Intervals, Database, Forms, Models, DataBinding etc) for customize this simple web calculator to extended 'scientific' one by the user interaction...","success");
    }
```

