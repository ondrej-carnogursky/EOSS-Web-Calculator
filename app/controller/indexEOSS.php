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
        //bind to custom keyboard events, added to libs/EOSS/eventList.json
        $this->csi->calc->onkeypressunicode[] = "keyPressed";
        $this->csi->calc->onkeydown[] = "keyDown";
        //display EOSS flash popup
        $this->csi->flash->onclick[] = "flash";
    }

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

    public function flash()
    {
        $this->flashMessage("Next I will try here some advanced features of EOSS (Register, Intervals, Database, Forms, Models, DataBinding etc) for customize this simple web calculator to extended 'scientific' one by the user interaction...","success");
    }

}