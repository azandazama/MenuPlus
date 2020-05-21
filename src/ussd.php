<?php
namespace MenuPlus;

class Ussd
{
    # global vars
    public $title = '';
    public $options = [];
    public $option_url = [];

    function addMenu($url)
    {
        $response = '<?xml version="1.0" encoding="utf-8"?>';
        $response .= '<request><headertext>'.$this->title.'</headertext>';
        $response .= '<options>';
        if(!empty($this->options))
        {
            for($i = 0;$i < count($this->options);$i++)
            {
                if(is_array($this->option_url))
                {
                    $response .= '<option command="'.($i+1).'" order="'.($i+1).'" callback="'.$url.''.$this->option_url[$i].'" display="true">'.$this->options[$i].'</option>';
                }
                else
                {
                    $response .= '<option command="'.($i+1).'" order="'.($i+1).'" callback="'.$url.''.$this->option_url.'" display="true">'.$this->options[$i].'</option>';
                }
            }
        }
        else if(empty($this->options) && !empty($this->option_url))
        {
            $response .= '<option command="1" order="1" callback="'.$url.''.$this->option_url.'" display="false">';
        }
        $response .= '</options></request>';
        return $response; 
    }

    function paginateMenu($url, $limit)
    {
        if(count($this->options) > $limit)
        {
            $pageCount = ceil(count($this->options)/$limit);

            if(!isset($_GET['file']) || $_GET['request'] == '*')
            {
                $page = 1;
                $response = '<?xml version="1.0" encoding="utf-8"?>';
                $response .= '<request><headertext>'.$this->title.' (1/'.$pageCount.')'."\n\n".'Press # to scroll down'."\n".'</headertext>';
                $response .= '<options>';
                $i = 1;
                $start = ($page-1) * $limit;
                $arrayData = array_splice($this->options, $start, $limit);
                $count = 1;
                for($i = 0;$i < count($arrayData); $i++)
                {
                    $response .= '<option command="'.$count.'" order="'.$count.'" callback="'.$url.''.$this->option_url.'" display="true">'.$arrayData[$i].'</option>';
                    $count++;
                }
                $response .= '<option command="'.$count.'" order="'.$count.'" callback="'.$url.'index.php?page='.$_GET['page'].'&file=2" display="false"></option>';
                $response .= '</options></request>';
                return $response; 
            } 
            else if($_GET['file'] >= 1)
            {
                # get current page count
                $count = $_GET['file'];
                if($count == $pageCount)
                {
                    # no scroll down opt
                    $response = '<?xml version="1.0" encoding="utf-8"?>';
                    $response .= '<request><headertext>'.$this->title.' ('.$count.'/'.$pageCount.')'."\n\n".'Press * to scroll up'."\n".'</headertext>';
                    $response .= '<options>';
                    # get numbering for options
                    $pg_cnt = $limit * $count;
                    $i = $pg_cnt - $limit + 1;
                    # get point where records will continue
                    $start = ($count-1) * $limit;
                    $arrayData = array_splice($this->options, $start, $limit);
                    $c = 1;
                    for($i = 0;$i < count($arrayData); $i++)
                    {
                        $response .= '<option command="'.$c.'" order="'.$c.'" callback="'.$url.''.$this->option_url.'" display="true">'.$arrayData[$i].'</option>';
                        $c++;
                    }
                    $response .= '<option command="'.($c+1).'" order="'.($c+1).'" callback="'.$url.'index.php?file='.$_GET['page'].'" display="false"></option>';
                    $response .= '</options></request>';
                    return $response; 
                }
                else
                {
                    # add scroll down opt 
                    $response = '<?xml version="1.0" encoding="utf-8"?>';
                    $response .= '<request><headertext>'.$this->title.' ('.$count.'/'.$pageCount.')'."\n\n".'Press # to scroll down'."\n".'</headertext>';
                    $response .= '<options>';
                    # get numbering for options
                    $pg_cnt = $limit * $count;
                    $i = $pg_cnt - $limit + 1;
                    # get point where records will continue
                    $start = ($count-1) * $limit;
                    $arrayData = array_splice($this->options, $start, $limit);
                    $c = 1;
                    for($i = 0;$i < count($arrayData); $i++)
                    {
                        $response .= '<option command="'.$c.'" order="'.$c.'" callback="'.$url.''.$this->option_url.'" display="true">'.$arrayData[$i].'</option>';
                        $c++;
                    }
                    $response .= '<option command="'.($c+1).'" order="'.($c+1).'" callback="'.$url.'index.php?page='.$_GET['page'].'&file='.($count+1).'" display="false"></option>';
                    $response .= '</options></request>';
                    return $response; 
                }
            }

        }
        else
        {
            $response = '<?xml version="1.0" encoding="utf-8"?>';
            $response .= "<request><headertext>".$this->title."\n</headertext>";
            $response .= '<options>';
            $count = 1;
            for($i = 0;$i < count($this->options); $i++)
            {
                $response .= '<option command="'.$count.'" order="'.$count.'" callback="'.$url.''.$this->option_url.'" display="true">'.$this->options[$i].'</option>';
                $count++;
            }
            $response .= '</options>';  
            $response .= '</request>';
            return $response;
        }
    }

}