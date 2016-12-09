# EOSS Web Calculator

At first I need to say, that I have never-ever program web application. The desktop is my ground and last years the C#, dotNet and WPF are my favourite technologies. Simply said, I'm too old for learning something so huge, as the Web is.

But with `EOSS` everything works like a charm. It's lightweight and simple, all you need is:

- copy `libs` and `assets` folders from [EOSS github repositary](https://github.com/Durisvk/EOSS2) to you root web folder
- copy `index.php` from the same repository to root
- create `temp` and `app` folder there
- copy `cofig.eoss` from reository to `app` folder
- add at least two folders to `app` folder (default is `controller` and `view`, but you can override this in `config.eoss`)
- add your own php controllers and html/php views to last two mentioned above (optionally you can create and fill-in `model` folder for a greater app)

And love to programming, because you need to write some handlers in php controller/model files, which has C-like syntax.

Of course, you can simply copy whole folder's hierarchy from repositary, where you can find `\app\controllers\indexEOSS.php` and `app\views\indexView.php` ready to use. Here is how it looks like:
![Folders](https://github.com/ondrej11/EOSS-Web-Calculator/blob/master/Folders.jpg)

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

Simple page with twenty buttons and one ***`div`*** tag for displaing the result, all aligned in old good table with some simple styling through CSS and inline style.
What is important is ***id*** for '=','C' and 'CE' buttons and 'data-group' attribute for digit buttons 0-9 and operator buttons '+','-','*','/', including '+/-' for negation. 

...