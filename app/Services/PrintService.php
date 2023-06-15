<?php

namespace App\Services;

use App\Models\Emitente;
use NFePHP\POS\PrintConnectors\Base64PrintConnector;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\Printer;
use NFePHP\POS\DanfcePos;

class PrintService
{

    public function printSaleCupom(object $business, object $sale, object $vendedor)
    {
        //armazena todo o codigo para impressão
        $connector = new Base64PrintConnector();

        $printer = new Printer($connector);

        /* Initialize */
        $printer->initialize();


        //header ================================================================================================
        $printer->setJustification(Printer::JUSTIFY_CENTER);

        if (isset($business->logo) && ($business->logo != null && $business->logo != '')) {
            $logopath = EscposImage::load(storage_path("app/public/{$business->logo}"));
            $printer->bitImage($logopath);
        }

        $printer->setEmphasis(true);
        $printer->text($business->fantasia . "\n");
        $printer->setEmphasis(false);

        $printer->setFont(Printer::FONT_B);
        $printer->text((strlen($business->cnpj) == 11) ? $this->mask($business->cnpj, '###.###.###-##') :
            $this->mask($business->cnpj, '##.###.###/####-##') . "\n");

        $printer->text($business->logradouro . ', ' . $business->numero . ' - ' . $business->bairro . "\n");
        $printer->text($business->cidade . '/' . $business->uf . ' - ' . $this->mask($business->cep, '##.###-###') . "\n\n");

        $printer->text($this->mask($business->telefone, '(##) ####-####') . "\n\n");

        $printer->setFont(Printer::FONT_A);

        //Fim header ================================================================================================


        //sub Header ================================================================================================
        $printer->setEmphasis(true);
        $printer->text("Cupom não fiscal \n");
        $printer->setEmphasis(false);

        $printer->setJustification(Printer::JUSTIFY_LEFT);

        $line = str_pad("Cupom:" . $sale->id, 24, " ", STR_PAD_RIGHT);
        $line .= str_pad("Data:" . date('d/m/Y H:i', strtotime($sale->created_at)), 24, " ", STR_PAD_LEFT);

        $printer->text($line);
        //Fim sub Header ================================================================================================

        $printer->text($this->separador());

        //Itens do cupom ================================================================================================
        $printer->setEmphasis(true);
        $line = str_pad(strtoupper("cod"), 7, " ", STR_PAD_RIGHT);
        $line .= str_pad(strtoupper("descricao"), 18, " ", STR_PAD_RIGHT);
        $line .= str_pad(strtoupper("Qtd."), 9, " ", STR_PAD_RIGHT);
        $line .= str_pad(strtoupper("Unit."), 9, " ", STR_PAD_RIGHT);
        $line .= str_pad(strtoupper("Total"), 9, " ", STR_PAD_RIGHT);

        $printer->text($line . "\n");
        $printer->setEmphasis(false);

        //sql Itens
        $count_itens = 0;
        $vdesc_itens = 0;
        $total_venda = 0;
        foreach ($sale->itens as $item) {

            $cod = isset($item->product->codigo_barras) ? $item->product->codigo_barras : $item->product->referencia;
            $descricao = substr($item->produto, 0, 30);
            $quantidade = number_format($item->quantidade, 3, ',', '.');
            $valor_unitario = number_format($item->valor_unitario, 2, ',', '.');
            $total = number_format($item->valor_unitario * $item->quantidade - $item->desconto, 2, ',', '.');

            //somas externas
            $count_itens++;
            $vdesc_itens += $item->desconto;
            $total_venda += $item->valor_unitario * $item->quantidade;

            $line = str_pad(strtoupper($cod), 7, " ", STR_PAD_RIGHT);
            $line .= " " . str_pad(strtoupper($descricao), 35, " ", STR_PAD_RIGHT);
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->text($line);

            $line = $quantidade;
            $line .= str_pad(strtoupper($valor_unitario), 12, " ", STR_PAD_LEFT);
            $line .= str_pad(strtoupper($total), 12, " ", STR_PAD_LEFT);
            $printer->setJustification(Printer::JUSTIFY_RIGHT);
            $printer->text($line . "\n\n");
        }

        $descontos = $sale->desconto + $vdesc_itens;

        $total_final = $total_venda - $descontos;

        $printer->text($this->separador());

        //Fim Itens do cupom ================================================================================================

        //Pagamento do cupom ================================================================================================

        $printer->setJustification(Printer::JUSTIFY_RIGHT);
        $printer->setEmphasis(true);

        $line = str_pad("Itens: ", 30, " ", STR_PAD_LEFT);
        $line .= str_pad($count_itens, 18, " ", STR_PAD_LEFT);
        $printer->text($line . "\n");

        $line = str_pad("subtotal: ", 30, " ", STR_PAD_LEFT);
        $line .= str_pad("R$ " . number_format($total_venda, 2, ',', '.'), 18, " ", STR_PAD_LEFT);
        $printer->text($line . "\n");

        $line = str_pad("Descontos: ", 30, " ", STR_PAD_LEFT);
        $line .= str_pad("R$ " . number_format($descontos, 2, ',', '.'), 18, " ", STR_PAD_LEFT);
        $printer->text($line . "\n");

        $line = str_pad("Total: ", 30, " ", STR_PAD_LEFT);
        $line .= str_pad("R$ " . number_format($total_final, 2, ',', '.'), 18, " ", STR_PAD_LEFT);
        $printer->text($line . "\n");



        $printer->setEmphasis(false);

        $printer->text($this->separador('-'));

        //sql Payments
        $total_pago = 0;
        foreach ($sale->pagamentos as $item) {
            $forma = substr($item->forma, 0, 41);
            $valor = number_format($item->valor_pago, 2, ',', '.');

            //somas externas
            $total_pago += $item->valor_pago;

            $line = str_pad(strtoupper($forma) . ":", 33, " ", STR_PAD_LEFT);
            $line .= str_pad("R$ " . strtoupper($valor), 15, " ", STR_PAD_LEFT);
            $printer->text($line . "\n");
        }

        $printer->setEmphasis(true);

        $printer->text($this->separador('-'));

        $troco = round($total_pago - $total_final, 2);

        $line = str_pad("Troco:", 33, " ", STR_PAD_LEFT);
        $line .= str_pad("R$ $troco", 15, " ", STR_PAD_LEFT);
        $printer->text($line . "\n");

        $printer->setEmphasis(false);

        $printer->setJustification(Printer::JUSTIFY_LEFT);

        //Fim Pagamento do cupom ================================================================================================
        $printer->text($this->separador('-'));

        $printer->text("Operador: " . strtoupper($vendedor->nome) . "\n");

        $printer->text($this->separador('-'));

        $printer->setJustification(Printer::JUSTIFY_CENTER);

        $printer->setFont(Printer::FONT_B);
        $printer->text("Powered by ERP HPI\n");
        $printer->setFont(Printer::FONT_A);

        // for ($i=0; $i < 5; $i++) {
        $printer->feed();
        // }

        $printer->cut();
        $printer->close();

        // Obter impressão em base64
        $base64 = $connector->getBase64Data();

        // Retornar resposta
        return $base64;
    }

    public function printNFCeCupom($nota)
    {

        $emitente = Emitente::where('uuid', $nota->emitente_id)->first();

        $pathLogo = storage_path("app/public/{$emitente->logo}");

        $pathAmbiente = $nota->tipo_ambiente == 1 ? "producao" : "homologacao";
        $mes = date('Y-m', strtotime($nota->data_emissao));

        $pathXML = storage_path("app/public/{$emitente->company_id}/XML/{$emitente->cnpj}/NFCe/{$pathAmbiente}/autorizadas/{$mes}/{$nota->chave}.xml");

        // Inicializar conector
        $connector = new Base64PrintConnector();

        // Inicializar DanfcePos
        $danfcepos = new DanfcePos($connector);

        // Carregar logo da empresa
        $logopath = '../../fixtures/logo.png'; // Impressa no início da DANFCe
        $danfcepos->logo($pathLogo);

        // Carregar NFCe
        $xmlpath = '../../fixtures/nfce_exemplo.xml'; // Também poderia ser o conteúdo do XML, no lugar do path
        $danfcepos->loadNFCe($pathXML);

        // Gerar impressão
        $danfcepos->imprimir();

        // Obter impressão em base64
        $base64 = $connector->getBase64Data();

        // Retornar resposta
        return $base64;
    }

    public function mask($val, $mask)
    {
        $maskared = '';
        $k = 0;
        for ($i = 0; $i <= strlen($mask) - 1; $i++) {
            if ($mask[$i] == '#') {
                if (isset($val[$k]))
                    $maskared .= $val[$k++];
            } else {
                if (isset($mask[$i]))
                    $maskared .= $mask[$i];
            }
        }
        return $maskared;
    }

    public function separador($str = '=')
    {
        return str_repeat($str, 48) . "\n";
    }
}
