<?php


class Billing extends ApplicationModel
{

    /*
     * todayBilling calcula o faturamento de hoje
     */

    public static function todayBilling()
    {

        $today = date('Y-m-d');

        //contabiliza diárias com o valor da acomodação
        $payments = Payment::where('
                created_at >= $1
            ',['fields' => 'price', 'values' => [$today]
        ]);

        $payment_types = Payment::joins('
            INNER JOIN payment_types ON payment_types.id = payments.payment_type_id
            WHERE payments.created_at >= $1
            GROUP BY payment_type_id, payment_types.description
            ', ['fields' => 'payment_type_id, payment_types.description as payment_type_description,
                    count(*) as count, sum(payments.price) as total',
                'values' => [$today] ]
        );

        $total = [
            'total' => 0,
            'count' => 0,
            'payments' => $payment_types
        ];

        if ($payments) {
            foreach ($payments as $payment) {
                $price = $payment['price'];
                $total['total'] += $price;
            }
            $total['count'] = count($payments);
        }

        return $total;

    }

    /*
     * periodicBilling calcula o pagamento por periodo
     */

    public static function periodicBilling($start_date, $end_date)
    {

        $total = [
            'total' => 0,
            'count' => 0,
            'payments' => false
        ];

        if( !Utils::validDateTime($start_date, 'd/m/Y') || !Utils::validDateTime($end_date, 'd/m/Y') )
            return $total;

        $start_date = DateTime::createFromFormat('d/m/Y',$start_date)->format('Y-m-d');
        $end_date = DateTime::createFromFormat('d/m/Y',$end_date)->format('Y-m-d');

        $payments = Payment::joins('
            INNER JOIN accommodations ON accommodations.id = payments.accommodation_id
            INNER JOIN payment_types ON payment_types.id = payments.payment_type_id
            WHERE payments.created_at BETWEEN $1 AND $2
            ORDER BY payments.created_at DESC
            ', ['fields' => 'payment_type_id, payment_types.description as payment_type_description,
                    accommodations.control as accommodation_control,
                    accommodation_id,
                    payments.created_at as created_at, payments.price as price,
                    payments.note as note, payments.control as control,
                    payments.id as payment_id',
                'values' => [$start_date, $end_date] ]
        );

        $total['payments'] = $payments;

        if ($payments) {
            foreach ($payments as $payment) {
                $price = $payment['price'];
                $total['total'] += $price;
            }
            $total['count'] = count($payments);
        }

        return $total;

    }

    /*
     * toPdf gera o arquivo pdf a partir html
     * e salva na pasta files e devolve o nome do arquivo
     */

    public static function toPdf($html){
        require 'mpdf/mpdf.php';
        $mpdf=new mPDF('c','A4','','',32,25,27,25,16,13);
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->WriteHTML($html);
        $filename = date("ymdhis").'_faturamento.pdf';
        $file = APP_ROOT_FOLDER.'/app/assets/files/'.$filename;
        $mpdf->Output($file, 'F');

        return SITE_ROOT.'/app/assets/files/'.$filename;
    }


}

?>
