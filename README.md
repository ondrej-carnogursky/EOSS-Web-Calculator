# EOSS Web Calculator

At first I need to say, that I have never-ever program web application. The desktop is my ground and last years the C#, dotNet and WPF are my favourite technologies. Simply said, I'm too old for learning something so huge, as the Web is.

But with `EOSS` everything works like a charm. It's lightweight and simple, all you need is:

- copy 'libs' and 'assets' folders from [EOSS github repositary](https://github.com/Durisvk/EOSS2) to you root web folder
- copy 'index.php' from the same repository to root
- create 'temp' and 'app' folder there
- copy 'cofig.eoss' to 'app' folder
- add at least two folders to 'app' folder (default is 'controller' and 'view', but you can override this in 'config.eoss')
- add your own php controllers and html/php views to last two mentioned above (optionally you can create and fill-in 'model' folder for a greater app)

And love to programming, because you need to write some handlers in php controller/model files, which has C-like syntax.

Ok, let's look to the Calculator, the way of work is simply straightforward according to the EOSS documentation:

1. I started with html view "indexView.html"

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

Simple page with twenty input-buttons and one div tag for displaing the result, all aligned in old good table with some simple styling through CSS and inline style.
What is important is "id" for "=","C" and "CE" buttons and "data-group" attribute for digit-buttons 0-9 and operator-buttons '+','-','*','/' and also '+/-' for negation. 

Here is a little demonstration of EOSS:
[EOSS Video](https://www.youtube.com/watch?v=G5y7wY2yBp8&feature=youtu.be)

You start with a config file, which should look like this:

`app/config.eoss`:

```
    "home_eoss": "indexEOSS",
    "layout_dir": "view/",
    "models": "model/",
    "refresh": true,
    "enviroment": "debug"
```

`home_eoss` is a starting controller class, which is launched at the begining. It should contain the name of the class not the filename. The filename must be the same as the class name except for extension.
`layout_dir` is a directory path relative to `app/` folder where the views are located.
`models` is the path to the models of Your application. They are loaded at the very beginning before everything else.
`refresh` attribute tells the EOSS whether it should keep the session about the current state of Your EOSS class alive.
`enviroment` for now this property says if AJAX responses should be `console.log`ged.

Now that You have Your `config.eoss` ready, we can go ahead and create some stuff.

Let's create our view inside `app/view/` folder.

`app/view/layout.php`:

```html
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Todo</title>
</head>
<body>
    <div id="todos"></div>
    <input id="todo" type="text" />
    <input type="button" id="addTodo" value="Add Todo" />
</body>
</html>
```

Be careful about the elements id attributes. EOSS creates the structure of classes which will be called by these ids. It must not contain `-`. Now let's make our Todo list actually work by creating the `indexEOSS` inside our `app/controller/` directory.


`app/controller/indexEOSS.php`:

```php
<?php

use \EOSS\EOSS;

class indexEOSS extends EOSS
{

    private $counter = 1;

    public function load()
    {
        $this->csi->setFile("layout.php");
    }

    public function bind()
    {
        $this->csi->addTodo->onclick = "addTodoFunction";
    }

    public function addTodoFunction() {
        $this->csi->todos->html .= "<div>" . $this->counter . ": " . $this->csi->todo->value . "</div>";
        $this->csi->todo->value = "";
        $this->counter++;
    }


}
```

In load method we set the view file we've created earlier. We can pass parameters into the view by setting `$this->csi->params->anyKindOfParameter` to some value. Bind method is called after the EOSS generates the CSI structure of classes. Now we can access all of our view elements from `$this->csi->idOfAnElement`. In this phase we should bind all of the events and set all of the intervals we need. Events are passed as a string containing the name of the function. Then we need to implement this function. We can use private members and do with them whatever we want (e.g. increment them) and they will be stored inside Sessions.

This is it... We've got the working application.

# Events:

Let's create a `textbox` which content will be copied into a `div` element real-time.

First we will need a view. Let's create a `rewrite.php` file.

`app/view/rewrite/rewrite.php`:

```html
<!DOCTYPE html>
<html>
<head>
    <title><?= $title ?></title>
</head>
<body>
<div id="lblCopy"></div>
<input type="text" id="txtSource">
<input type="button" id="back" value="Back" />
<input type="button" id="next" value="Next" />
</body>
</html>
```

We will pass the `$title` parameter into the view from our EOSS controller. Let's now create `indexEOSS` class.

`app/controller/indexEOSS.php`:

```php
<?php

use \EOSS\EOSS;

class indexEOSS extends EOSS
{
    public function load()
    {
        $this->csi->setFile("rewrite/rewrite.php");
    }

    public function bind()
    {
        $this->csi->txtSource->onkeypress = "rewrite";
    }

    public function rewrite($keyCode) {
        $this->csi->lblCopy->html = $this->csi->txtSource->value;
    }


}
```

And we're done. That's it.

Available events(some will be added over time):

```json
{
  "onclick": "click",
  "onhover": "hover",
  "onchange": "change",
  "onfocus": "focus",
  "onfocusin": "focusin",
  "onfocusout": "focusout",
  "onload": "load",
  "onmousedown": "mousedown",
  "onkeypress": "keypress:keyCode"
}
```


# Intervals, Database and Registry:

Let's create something more advanced. We will create the chat application with the login information.

First let's create our login view.

`app/view/chat/chatLogin.php`:

```html

<!DOCTYPE html>
<html>
<head>
    <title>EOSS Introduction</title>
</head>
<body>
<div id="error" style="color: red"></div>
<input type="text" id="username" /><br>
<input type="password" id="password" /><br>
<input type="button" id="next" value="Next" />
</body>
</html>

```

Inside the `#error` we will print the `Invalid credentials` when the user enters wrong username or password.

Now let's create `indexEOSS`.

`app/controller/indexEOSS.php`:

```php
<?php

use \EOSS\EOSS;

class indexEOSS extends EOSS
{
    public function load()
    {
        $this->csi->setFile("chat/chatLogin.php");
    }

    public function bind()
    {
        $this->csi->next->onclick = "next";
    }


    public function next() {
        $database = new \Database\PDOWrapper('localhost', 'username', 'password', 'testdatabase');

        if($row = $database->prepareExecuteAndFetch("SELECT * FROM users WHERE username = ? AND password = ?", $this->csi->username->value, $this->csi->password->value)) {
            $this->csi->error->html = "";
            \EOSS\Registry::getInstance()->username = $this->csi->username->value;
            $this->redirect("chatEOSS");
        } else {
            $this->csi->error->html = "Invalid credentials.";
        }
    }


}
```

We will pass the username into the `chatEOSS` through the `Registry` which is the Singleton pattern and is stored inside Sessions.

Let's create a chat view.

`app/view/chat/chat.php`:

```html
<!DOCTYPE html>
<html>
<head>
    <title>EOSS Introduction</title>
</head>
<body>
<div id="chat"><?= isset($chat) ? $chat : "" ?></div>
<input type="text" id="message">
<input type="button" id="send" value="Send">
<input type="button" id="back" value="Back" />
</body>
</html>
```

Now we need to create a `ChatModel` which will look like this:

`app/models/ChatModel.php`:

```php
<?php

class ChatModel
{

    /**
     * @var \Database\PDOWrapper
     */
    private $database;

    public function __construct() {
        $this->database = new \Database\PDOWrapper('localhost', 'username', 'password', 'testdatabase');
    }

    public function getChatMessagesFormatted() {
        $chat = "";
        if($row = $this->database->queryAndFetchAll("SELECT * FROM chat LIMIT 10")) {
            foreach($row as $r) {
                $chat .= "<b>" . $r["username"] . "</b>: " . $r["message"] . "<br>";
            }
        }
        return $chat;
    }

    public function sendMessage($username, $message) {
        $this->database->prepareAndExecute("INSERT INTO chat(username, message) VALUES(?, ?)", $username, $message);
    }

}
```
Now let's create


Now we can finally create our `chatEOSS`.

`app/controller/chatEOSS.php`:

```php
<?php
use \EOSS\EOSS;

class chatEOSS extends EOSS
{

    /**
     * @var ChatModel|null
     */
    private $chatModel = NULL;

    public function load()
    {
        $this->chatModel = new ChatModel();

        $this->csi->setFile("chat/chat.php");

        $this->csi->params->chat = $this->chatModel->getChatMessagesFormatted();
    }


    public function bind()
    {
        $this->csi->send->onclick = "sendMsg";
        $this->csi->back->onclick = "back";
        $this->csi->intervals["reloadPosts"] = 500;
    }

    public function reloadPosts() {
        $this->csi->chat->html = $this->chatModel->getChatMessagesFormatted();
    }

    public function sendMsg() {
        $this->chatModel->sendMessage(\EOSS\Registry::getInstance()->username, $this->csi->message->value);
        $this->csi->message->value = "";
    }

    public function back() {
        $this->redirect("chatLoginEOSS");
    }



}
```

We've set the interval to call `reloadPosts` every 500 ms. The syntax is `$this->csi->intervals["functionYouWantToCall"] = 500`.

And now we're done...