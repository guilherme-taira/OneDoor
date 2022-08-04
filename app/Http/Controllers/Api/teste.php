 // CAIXA 10
        $pesquisas = DB::connection('caixa10')->table('PAF06')
            ->whereBetween('DATA', [$data, $data])
            ->where('ORCAMENTO', '!=', null)
            ->distinct()
            ->select('ORCAMENTO', 'DATA', 'SAT_CHAVE', 'PDV', 'VENDEDOR')
            ->get();

        foreach ($pesquisas as $value) {
            //VERIFICA SE JÀ FOI CADASTRADO O ORÇAMENTO
            if (!orcamentodados::VerifyNewOrder($value->ORCAMENTO) > 0) {
                //echo "CADASTRADO COM SUCESSO!";
                try {
                    $newOrder = new orcamentodados();
                    $newOrder->ORCNUM = $value->ORCAMENTO;
                    $newOrder->data = $value->DATA;
                    $newOrder->sat_chave = $value->SAT_CHAVE;
                    $newOrder->vendedor = $value->VENDEDOR;
                    $newOrder->terminal = $value->PDV;
                    $newOrder->save();
                    // ENVIA PARA A FILA O ORÇAMENTO
                    \App\Jobs\sendOrcamentoViaApi::dispatch($value->ORCAMENTO);
                } catch (\Exception $e) {
                    //echo "Erro ao gerar o pedido Orçamento: " . $value->ORCAMENTO;
                }
            }
        }

        // CAIXA 11
        $pesquisas = DB::connection('caixa11')->table('PAF06')
            ->whereBetween('DATA', [$data, $data])
            ->where('ORCAMENTO', '!=', null)
            ->distinct()
            ->select('ORCAMENTO', 'DATA', 'SAT_CHAVE', 'PDV', 'VENDEDOR')
            ->get();

        foreach ($pesquisas as $value) {
            //VERIFICA SE JÀ FOI CADASTRADO O ORÇAMENTO
            if (!orcamentodados::VerifyNewOrder($value->ORCAMENTO) > 0) {
                //echo "CADASTRADO COM SUCESSO!";
                try {
                    $newOrder = new orcamentodados();
                    $newOrder->ORCNUM = $value->ORCAMENTO;
                    $newOrder->data = $value->DATA;
                    $newOrder->sat_chave = $value->SAT_CHAVE;
                    $newOrder->vendedor = $value->VENDEDOR;
                    $newOrder->terminal = $value->PDV;
                    $newOrder->save();
                    // ENVIA PARA A FILA O ORÇAMENTO
                    \App\Jobs\sendOrcamentoViaApi::dispatch($value->ORCAMENTO);
                } catch (\Exception $e) {
                    //echo "Erro ao gerar o pedido Orçamento: " . $value->ORCAMENTO;
                }
            }
        }



