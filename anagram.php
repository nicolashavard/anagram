<?php

class master
{
    private $anagram;
    private $anagram_sort;
    private $nb = null;
    private $dico_len = array();
    private $dico_sortr = array();
    private $anagram_len;
    private $the_almost_good_one = array();
    private $the_good_one = array();
    public $dico_find = array();
    public $source;
    public function __construct($argv)
    {
        if(isset($argv[1]))
        {
            $this->anagram = $argv[1];
        }
        else
        {
            echo "il est necessaire d'avoir un mot\n";
            die;
        }
        if(isset($argv[2]))
        {
            if($argv[2]==0)
            {
                echo "Veuillez entrer un nombre correct\nexec time: 0S\n";
                die;
            }
            $this->nb = $argv[2];
        }
        $this->anagram_len = strlen($this->anagram) - $this->nb;
        $this->anagram_sort = $this->sort($this->anagram);
    }
    public function dictionnaire() // permet de recuperer les mots de memes taille
    {
        $this->source = fopen("anagram-master-dictionnaire.txt", "r");
        $i=0;
        while($i < 337000)
        {
            $word = fgets($this->source);
            if((strlen($word)-1) == $this->anagram_len)
            {
                $this->dico_len[] = $word;
            }
            $i++;
        }
        $this->dico_sort();
    }
    public function dico_sort()
    {
        foreach($this->dico_len as $value)
        {
            $this->dico_sortr[] = $this->sort($value); // value triee
        }
        $this->compare();
    }
    public function sort($string)
    {
        $tab = array();
        for($i = 0; $i < Strlen($string); $i++)
        {
            $tab[] = $string[$i];
        }
        return($this->to_string($this->bubble_Sort($tab)));
    }
    function bubble_Sort($my_array)
    {
        do
        {
            $swapped = false;
            for($i = 0, $c = count($my_array) - 1; $i < $c; $i++ )
            {
                if($my_array[$i] > $my_array[$i + 1] )
                {
                    $boite = $my_array[$i];
                    $my_array[$i] = $my_array[$i+1];
                    $my_array[$i+1] = $boite;
                    $swapped = true;
                }
            }
        }
        while($swapped);
        return $my_array;
    }
    private function to_string($tab)
    {
        $str="";
        foreach($tab as $value)
        {
            $str.=$value;
        }
        return($str);
    }
    private function compare()
    {
        foreach ($this->dico_sortr as $key => $value)
        {
            if($value == ("\n".$this->anagram_sort))
            {
                $this->dico_find[$key] = $value;
            }
        }
        $this->lister();
    }
    private function lister()
    {
        foreach ($this->dico_find as $key => $value)
        {
            $this->the_almost_good_one[] = $this->dico_len[$key];
        }
        $this->ho_yeah();
    }
    private function ho_yeah()
    {
        foreach ($this->the_almost_good_one as $value)
        {
            if($value != $this->anagram."\n")
            {
                $this->the_good_one[] = $value;
            }
        }
        if(!isset($this->the_good_one[0]))
        {
            echo "pas de resultat\n";
        }
        else
        {
            print_r($this->the_good_one);
            echo "exec time: " . round(microtime(), 2) . "s\n";
        }
    }
}

$nicolas = new master($argv);
$nicolas->dictionnaire();