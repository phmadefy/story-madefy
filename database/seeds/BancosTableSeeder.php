<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BancosTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('bancos')->delete();

        \DB::table('bancos')->insert([
            "codigo" =>1,
            "descricao" => "Banco do Brasil S.A.",
            "path_homolog" => "https://api.hm.bb.com.br/cobrancas/v2",
            "path_prod" => "https://api.bb.com.br/cobrancas/v2",
            "oath_homolog_path" => "https://oauth.sandbox.bb.com.br",
            "oath_prod_path" => "https://oauth.bb.com.br"
        ]);

        \DB::table('bancos')->insert(["codigo" =>3, "descricao" => "Banco da Amazônia S.A."]);
        \DB::table('bancos')->insert(["codigo" =>4, "descricao" => "Banco do Nordeste do Brasil S.A."]);
        \DB::table('bancos')->insert(["codigo" =>12, "descricao" => "Banco Inbursa S.A."]);
        \DB::table('bancos')->insert(["codigo" =>17, "descricao" => "BNY Mellon Banco S.A."]);
        \DB::table('bancos')->insert(["codigo" =>21, "descricao" => "BANESTES S.A. Banco do Estado do Espírito Santo"]);
        \DB::table('bancos')->insert(["codigo" =>24, "descricao" => "Banco BANDEPE S.A."]);
        \DB::table('bancos')->insert(["codigo" =>25, "descricao" => "Banco Alfa S.A."]);
        \DB::table('bancos')->insert(["codigo" =>29, "descricao" => "Banco Itaú Consignado S.A."]);
        \DB::table('bancos')->insert(["codigo" =>33, "descricao" => "Banco Santander (Brasil) S.A."]);
        \DB::table('bancos')->insert(["codigo" =>36, "descricao" => "Banco Bradesco BBI S.A."]);
        \DB::table('bancos')->insert(["codigo" =>37, "descricao" => "Banco do Estado do Pará S.A."]);
        \DB::table('bancos')->insert(["codigo" =>40, "descricao" => "Banco Cargill S.A."]);
        \DB::table('bancos')->insert(["codigo" =>41, "descricao" => "Banco do Estado do Rio Grande do Sul S.A."]);
        \DB::table('bancos')->insert(["codigo" =>47, "descricao" => "Banco do Estado de Sergipe S.A."]);
        \DB::table('bancos')->insert(["codigo" =>62, "descricao" => "Hipercard Banco Múltiplo S.A."]);
        \DB::table('bancos')->insert(["codigo" =>63, "descricao" => "Banco Bradescard S.A."]);
        \DB::table('bancos')->insert(["codigo" =>65, "descricao" => "Banco Andbank (Brasil) S.A."]);
        \DB::table('bancos')->insert(["codigo" =>70, "descricao" => "BRB - Banco de Brasília S.A."]);
        \DB::table('bancos')->insert(["codigo" =>74, "descricao" => "Banco J. Safra S.A."]);
        \DB::table('bancos')->insert(["codigo" =>75, "descricao" => "Banco ABN AMRO S.A."]);
        \DB::table('bancos')->insert(["codigo" =>77, "descricao" => "Banco Inter S.A."]);
        \DB::table('bancos')->insert(["codigo" =>82, "descricao" => "Banco Topázio S.A."]);
        \DB::table('bancos')->insert(["codigo" =>83, "descricao" => "Banco da China Brasil S.A."]);
        \DB::table('bancos')->insert(["codigo" =>94, "descricao" => "Banco Finaxis S.A."]);
        \DB::table('bancos')->insert(["codigo" =>95, "descricao" => "Travelex Banco de Câmbio S.A."]);
        \DB::table('bancos')->insert(["codigo" =>96, "descricao" => "Banco B3 S.A."]);
        \DB::table('bancos')->insert(["codigo" =>102, "descricao" => "Banco XP S.A."]);
        \DB::table('bancos')->insert(["codigo" =>104, "descricao" => "Caixa Econômica Federal"]);
        \DB::table('bancos')->insert(["codigo" =>107, "descricao" => "Banco BOCOM BBM S.A."]);
        \DB::table('bancos')->insert(["codigo" =>119, "descricao" => "Banco Western Union do Brasil S.A."]);
        \DB::table('bancos')->insert(["codigo" =>120, "descricao" => "Banco Rodobens S.A."]);
        \DB::table('bancos')->insert(["codigo" =>121, "descricao" => "Banco Agibank S.A."]);
        \DB::table('bancos')->insert(["codigo" =>125, "descricao" => "Plural S.A. - Banco Múltiplo"]);
        \DB::table('bancos')->insert(["codigo" =>128, "descricao" => "MS Bank S.A. Banco de Câmbio"]);
        \DB::table('bancos')->insert(["codigo" =>129, "descricao" => "UBS Brasil Banco de Investimento S.A."]);
        \DB::table('bancos')->insert(["codigo" =>144, "descricao" => "BEXS Banco de Câmbio S.A."]);
        \DB::table('bancos')->insert(["codigo" =>169, "descricao" => "Banco Olé Bonsucesso Consignado S.A."]);
        \DB::table('bancos')->insert(["codigo" =>184, "descricao" => "Banco Itaú BBA S.A."]);
        \DB::table('bancos')->insert(["codigo" =>208, "descricao" => "Banco BTG Pactual S.A."]);
        \DB::table('bancos')->insert(["codigo" =>212, "descricao" => "Banco Original S.A."]);
        \DB::table('bancos')->insert(["codigo" =>217, "descricao" => "Banco John Deere S.A."]);
        \DB::table('bancos')->insert(["codigo" =>218, "descricao" => "Banco BS2 S.A."]);
        \DB::table('bancos')->insert(["codigo" =>222, "descricao" => "Banco Credit Agricole Brasil S.A."]);
        \DB::table('bancos')->insert(["codigo" =>224, "descricao" => "Banco Fibra S.A."]);
        \DB::table('bancos')->insert(["codigo" =>233, "descricao" => "Banco Cifra S.A."]);
        \DB::table('bancos')->insert(["codigo" =>237, "descricao" => "Banco Bradesco S.A."]);
        \DB::table('bancos')->insert(["codigo" =>243, "descricao" => "Banco Máxima S.A."]);
        \DB::table('bancos')->insert(["codigo" =>246, "descricao" => "Banco ABC Brasil S.A."]);
        \DB::table('bancos')->insert(["codigo" =>249, "descricao" => "Banco Investcred Unibanco S.A."]);
        \DB::table('bancos')->insert(["codigo" =>250, "descricao" => "BCV - Banco de Crédito e Varejo S.A."]);
        \DB::table('bancos')->insert(["codigo" =>254, "descricao" => "Paraná Banco S.A."]);
        \DB::table('bancos')->insert(["codigo" =>269, "descricao" => "HSBC Brasil S.A. - Banco de Investimento"]);
        \DB::table('bancos')->insert(["codigo" =>276, "descricao" => "Banco Senff S.A."]);
        \DB::table('bancos')->insert(["codigo" =>299, "descricao" => "Banco Sorocred S.A. - Banco Múltiplo (AFINZ)"]);
        \DB::table('bancos')->insert(["codigo" =>318, "descricao" => "Banco BMG S.A."]);
        \DB::table('bancos')->insert(["codigo" =>320, "descricao" => "China Construction Bank (Brasil) Banco Múltiplo S.A."]);
        \DB::table('bancos')->insert(["codigo" =>341, "descricao" => "Itaú Unibanco S.A."]);
        \DB::table('bancos')->insert(["codigo" =>366, "descricao" => "Banco Société Générale Brasil S.A."]);
        \DB::table('bancos')->insert(["codigo" =>370, "descricao" => "Banco Mizuho do Brasil S.A."]);
        \DB::table('bancos')->insert(["codigo" =>376, "descricao" => "Banco J. P. Morgan S.A."]);
        \DB::table('bancos')->insert(["codigo" =>389, "descricao" => "Banco Mercantil do Brasil S.A."]);
        \DB::table('bancos')->insert(["codigo" =>394, "descricao" => "Banco Bradesco Financiamentos S.A."]);
        \DB::table('bancos')->insert(["codigo" =>399, "descricao" => "Kirton Bank S.A. - Banco Múltiplo"]);
        \DB::table('bancos')->insert(["codigo" =>422, "descricao" => "Banco Safra S.A."]);
        \DB::table('bancos')->insert(["codigo" =>456, "descricao" => "Banco MUFG Brasil S.A."]);
        \DB::table('bancos')->insert(["codigo" =>464, "descricao" => "Banco Sumitomo Mitsui Brasileiro S.A."]);
        \DB::table('bancos')->insert(["codigo" =>473, "descricao" => "Banco Caixa Geral - Brasil S.A."]);
        \DB::table('bancos')->insert(["codigo" =>477, "descricao" => "Citibank N.A."]);
        \DB::table('bancos')->insert(["codigo" =>479, "descricao" => "Banco ItauBank S.A"]);
        \DB::table('bancos')->insert(["codigo" =>487, "descricao" => "Deutsche Bank S.A. - Banco Alemão"]);
        \DB::table('bancos')->insert(["codigo" =>488, "descricao" => "JPMorgan Chase Bank, National Association"]);
        \DB::table('bancos')->insert(["codigo" =>492, "descricao" => "ING Bank N.V."]);
        \DB::table('bancos')->insert(["codigo" =>505, "descricao" => "Banco Credit Suisse (Brasil) S.A."]);
        \DB::table('bancos')->insert(["codigo" =>600, "descricao" => "Banco Luso Brasileiro S.A."]);
        \DB::table('bancos')->insert(["codigo" =>604, "descricao" => "Banco Industrial do Brasil S.A."]);
        \DB::table('bancos')->insert(["codigo" =>610, "descricao" => "Banco VR S.A."]);
        \DB::table('bancos')->insert(["codigo" =>611, "descricao" => "Banco Paulista S.A."]);
        \DB::table('bancos')->insert(["codigo" =>612, "descricao" => "Banco Guanabara S.A."]);
        \DB::table('bancos')->insert(["codigo" =>623, "descricao" => "Banco PAN S.A."]);
        \DB::table('bancos')->insert(["codigo" =>626, "descricao" => "Banco C6 Consignado S.A."]);
        \DB::table('bancos')->insert(["codigo" =>630, "descricao" => "Banco Smartbank S.A."]);
        \DB::table('bancos')->insert(["codigo" =>633, "descricao" => "Banco Rendimento S.A."]);
        \DB::table('bancos')->insert(["codigo" =>634, "descricao" => "Banco Triângulo S.A."]);
        \DB::table('bancos')->insert(["codigo" =>643, "descricao" => "Banco Pine S.A."]);
        \DB::table('bancos')->insert(["codigo" =>653, "descricao" => "Banco Indusval S.A."]);
        \DB::table('bancos')->insert(["codigo" =>654, "descricao" => "Banco Digimais S.A."]);
        \DB::table('bancos')->insert(["codigo" =>655, "descricao" => "Banco Votorantim S.A."]);
        \DB::table('bancos')->insert(["codigo" =>707, "descricao" => "Banco Daycoval S.A."]);
        \DB::table('bancos')->insert(["codigo" =>739, "descricao" => "Banco Cetelem S.A."]);
        \DB::table('bancos')->insert(["codigo" =>743, "descricao" => "Banco Semear S.A."]);
        \DB::table('bancos')->insert(["codigo" =>745, "descricao" => "Banco Citibank S.A."]);
        \DB::table('bancos')->insert(["codigo" =>746, "descricao" => "Banco Modal S.A."]);
        \DB::table('bancos')->insert(["codigo" =>747, "descricao" => "Banco Rabobank International Brasil S.A."]);
        \DB::table('bancos')->insert(["codigo" =>748, "descricao" => "Banco Cooperativo Sicredi S.A."]);
        \DB::table('bancos')->insert(["codigo" =>751, "descricao" => "Scotiabank Brasil S.A. Banco Múltiplo"]);
        \DB::table('bancos')->insert(["codigo" =>752, "descricao" => "Banco BNP Paribas Brasil S.A."]);
        \DB::table('bancos')->insert(["codigo" =>755, "descricao" => "Bank of America Merrill Lynch Banco Múltiplo S.A."]);
        \DB::table('bancos')->insert(["codigo" =>756, "descricao" => "Banco Cooperativo do Brasil S.A. - BANCOOB"]);
    }
}
