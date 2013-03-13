<?
class Via {
	private $nome;	
	private $grado;
	private $grado_proposto;
	private $ripetizioni;
	private $regione;
	private $link_value;
	private $html;
	private $retriever;
	public function __construct($link_value, $retriever) {	
		$this->link_value = $link_value;
		$this->retriever = $retriever;
		$this->html = $this->connect();
		$this->extract_dati();
		$this->html->clear(); 
		unset($this->html);
	}
	private function extract_dati()
	{
		$notes = $this->html->find('dd[class=notes]');
		$testo = $this->html->find('dd');
		
		$this->nome = $testo[0]->plaintext;
		$this->settore = $testo[1]->plaintext;
		$this->regione = $testo[2]->plaintext;
		
		if (strpos($notes[0], " ") !== false)
		{
			$this->grado = $testo[4]->plaintext;
			$this->grado_ufficiale = $testo[5]->plaintext;
		}
		else
		{
			$this->grado = $testo[3]->plaintext;
			$this->grado_proposto = $testo[4]->plaintext;
			if (count($testo) == 6)
			{
				$this->ripetizioni = $testo[5]->plaintext;
			}
			else if (count($testo) == 8)
			{
				$this->grado = $testo[4]->plaintext;
				$this->grado_proposto = $testo[5]->plaintext;
				$this->ripetizioni = $testo[7]->plaintext;

			}
			else
			{
				$this->ripetizioni = $testo[6]->plaintext;
			}
		}
	}

	private function constructLink($link)
	{
	        $url_vie = "http://www.climbook.com".$link."/";
        	return $url_vie;
	}

	private function connect() {
		$url = $this->constructLink($this->getLink());
                $page = file_get_html($url);
                if ($page==false)
                {
                	return null;
                }

		return $page;

	}

	public function getGrado()
	{
		return $this->grado;
	}
	public function getNome()
	{
		return $this->nome;
	}
	public function getGradoProposto()
	{
		return $this->grado_proposto;
	}

	public function getRipetizioni()
	{
		return $this->ripetizioni;
	}
	public function getLink()
	{
		return $this->link_value;
	}
	public function getSettore()
	{
		return $this->settore;
	}
}
?>
