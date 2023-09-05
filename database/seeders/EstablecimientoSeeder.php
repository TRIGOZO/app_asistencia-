<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Establecimiento;
class EstablecimientoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $establecimiento = Establecimiento::firstOrCreate(['codigo' => '100102001','nombre' => 'SEDE RED SALUD HUANUCO', 'microred_id' => 1]);
        $establecimiento = Establecimiento::firstOrCreate(['codigo' => '100101201','nombre' => 'C.S. APARICIO POMARES', 'microred_id' => 1]);
        $establecimiento = Establecimiento::firstOrCreate(['codigo' => '100101202','nombre' => 'C.S. LAS MORAS', 'microred_id' => 1]);
        $establecimiento = Establecimiento::firstOrCreate(['codigo' => '100101301','nombre' => 'P.S. COLPA BAJA', 'microred_id' => 1]);
        $establecimiento = Establecimiento::firstOrCreate(['codigo' => '100101302','nombre' => 'P.S. NAUYAN RONDOS', 'microred_id' => 1]);
        $establecimiento = Establecimiento::firstOrCreate(['codigo' => '100101303','nombre' => 'C.S.M.C. ESPERANZA', 'microred_id' => 1]);
       
        $establecimiento = Establecimiento::firstOrCreate(['codigo' => '100102101','nombre' => 'HOSPITAL CARLOS SHOWING FERRARI', 'microred_id' => 2]);
        $establecimiento = Establecimiento::firstOrCreate(['codigo' => '100102201','nombre' => 'C.S. PERU COREA', 'microred_id' => 2]);
        $establecimiento = Establecimiento::firstOrCreate(['codigo' => '100102301','nombre' => 'P.S. LA ESPERANZA', 'microred_id' => 2]);
        $establecimiento = Establecimiento::firstOrCreate(['codigo' => '100102302','nombre' => 'P.S. PAUCAR', 'microred_id' => 2]);
        $establecimiento = Establecimiento::firstOrCreate(['codigo' => '100102303','nombre' => 'P.S. MALCONGA', 'microred_id' => 2]);
        $establecimiento = Establecimiento::firstOrCreate(['codigo' => '100102304','nombre' => 'P.S. LLICUA', 'microred_id' => 2]);
        $establecimiento = Establecimiento::firstOrCreate(['codigo' => '100102305','nombre' => 'C.S.M.C. PAKARY', 'microred_id' => 2]);
        $establecimiento = Establecimiento::firstOrCreate(['codigo' => '100102306','nombre' => 'C.S.AMARILIS', 'microred_id' => 2]);

        $establecimiento = Establecimiento::firstOrCreate(['codigo' => '100103201','nombre' => 'C.S. ACOMAYO', 'microred_id' => 3]);
        $establecimiento = Establecimiento::firstOrCreate(['codigo' => '100103301','nombre' => 'P.S. STO.TBIO MJO AMP CHINCHAO', 'microred_id' => 3]);
        $establecimiento = Establecimiento::firstOrCreate(['codigo' => '100103302','nombre' => 'P.S. PUEBLO LIBRE DE MAYOBAMBA', 'microred_id' => 3]);
        $establecimiento = Establecimiento::firstOrCreate(['codigo' => '100103303','nombre' => 'P.S.PUENTE DURAND', 'microred_id' => 3]);
        $establecimiento = Establecimiento::firstOrCreate(['codigo' => '111111111','nombre' => 'P.S. TAPRAG', 'microred_id' => 3]);

        $establecimiento = Establecimiento::firstOrCreate(['codigo' => '100113201','nombre' => 'C.S. PILLAO', 'microred_id' => 13]);
        $establecimiento = Establecimiento::firstOrCreate(['codigo' => '100113301','nombre' => 'P.S. CHINCHINGA', 'microred_id' => 13]);
        $establecimiento = Establecimiento::firstOrCreate(['codigo' => '100113302','nombre' => 'P.S. HUANACAURE', 'microred_id' => 13]);
        $establecimiento = Establecimiento::firstOrCreate(['codigo' => '100113303','nombre' => 'P.S. SANTA ISABEL', 'microred_id' => 13]);
        $establecimiento = Establecimiento::firstOrCreate(['codigo' => '100113304','nombre' => 'P.S. SAN PEDRO DE PILLAO', 'microred_id' => 13]);

        $establecimiento = Establecimiento::firstOrCreate(['codigo' => '100104201','nombre' => 'P.S. CHURUBAMBA', 'microred_id' => 4]);
        $establecimiento = Establecimiento::firstOrCreate(['codigo' => '100104302','nombre' => 'P.S. TAMBOGAN', 'microred_id' => 4]);
        $establecimiento = Establecimiento::firstOrCreate(['codigo' => '100104303','nombre' => 'P.S. UTAO' , 'microred_id'=> 4]);
        $establecimiento = Establecimiento::firstOrCreate(['codigo' => '100104304','nombre' => 'P.S. TRES DE MAYO DE PACSHAG', 'microred_id' => 4]);
        $establecimiento = Establecimiento::firstOrCreate(['codigo' => '100104305','nombre' => 'P.S. MANANTIAL DE VIDA DE QUECHUALO', 'microred_id' => 4]);
        $establecimiento = Establecimiento::firstOrCreate(['codigo' => '100104306','nombre' => 'P.S. SN FCO.DE COCHABAMBA', 'microred_id' => 4]);
        $establecimiento = Establecimiento::firstOrCreate(['codigo' => '100104307','nombre' => 'P.S. HUALLMISH', 'microred_id' => 4]);

        $establecimiento = Establecimiento::firstOrCreate(['codigo' => '100105201','nombre' => 'C.S. MARGOS', 'microred_id' => 5]);
        $establecimiento = Establecimiento::firstOrCreate(['codigo' => '100105301','nombre' => 'P.S. JESUS DE NAZARET DE COCHAS', 'microred_id' => 5]);
        $establecimiento = Establecimiento::firstOrCreate(['codigo' => '100105302','nombre' => 'P.S. PACAYHUA', 'microred_id' => 5]);
        $establecimiento = Establecimiento::firstOrCreate(['codigo' => '100105303','nombre' => 'P.S. HUALLMISH', 'microred_id' => 5]);

        $establecimiento = Establecimiento::firstOrCreate(['codigo' => '100106201','nombre' => 'C.S. HUANCAPALLAC', 'microred_id' => 6]);
        $establecimiento = Establecimiento::firstOrCreate(['codigo' => '100106301','nombre' => 'P.S. PAMPAS', 'microred_id' => 6]);
        $establecimiento = Establecimiento::firstOrCreate(['codigo' => '100106302','nombre' => 'P.S. SAN PEDRO DE CANI', 'microred_id' => 6]);
       
        $establecimiento = Establecimiento::firstOrCreate(['codigo' => '100107201','nombre' => 'C.S. CAYRAN', 'microred_id' => 7]);
        $establecimiento = Establecimiento::firstOrCreate(['codigo' => '100107301','nombre' => 'P.S. HUANCACHUPAC', 'microred_id' => 7]);
       
        $establecimiento = Establecimiento::firstOrCreate(['codigo' => '100108201','nombre' => 'C.S. CHAULAN', 'microred_id' => 8]);
        $establecimiento = Establecimiento::firstOrCreate(['codigo' => '100108301','nombre' => 'P.S. SAN JUAN DE LA LIBERTAD', 'microred_id' => 8]);
        $establecimiento = Establecimiento::firstOrCreate(['codigo' => '100108302','nombre' => 'P.S. SAN JOSE DE COZO TINGO', 'microred_id' => 8]);
       
        $establecimiento = Establecimiento::firstOrCreate(['codigo' => '100109201','nombre' => 'C.S. STA. MARIA DEL VALLE', 'microred_id' => 9]);
        $establecimiento = Establecimiento::firstOrCreate(['codigo' => '100109202','nombre' => 'C.S. SAN SEBASTIAN DE QUERA', 'microred_id' => 9]);
        $establecimiento = Establecimiento::firstOrCreate(['codigo' => '100109301','nombre' => 'P.S. LLACON', 'microred_id' => 9]);
        $establecimiento = Establecimiento::firstOrCreate(['codigo' => '100109302','nombre' => 'P.S. PACHABAMBA', 'microred_id' => 9]);
        $establecimiento = Establecimiento::firstOrCreate(['codigo' => '100109303','nombre' => 'P.S. POMACUCHO', 'microred_id' => 9]);
        $establecimiento = Establecimiento::firstOrCreate(['codigo' => '100109304','nombre' => 'P.S. SANTA CRUZ DE RATACOCHA', 'microred_id' => 9]);
        $establecimiento = Establecimiento::firstOrCreate(['codigo' => '100109305','nombre' => 'P.S. SANTA ROSA DE SIRABAMBA', 'microred_id' => 9]);
        $establecimiento = Establecimiento::firstOrCreate(['codigo' => '100109306','nombre' => 'P.S. TAMBO DE SAN JOSE', 'microred_id' => 9]);
        $establecimiento = Establecimiento::firstOrCreate(['codigo' => '100109307','nombre' => 'P.S. LLACSA', 'microred_id' => 9]);
        $establecimiento = Establecimiento::firstOrCreate(['codigo' => '100109308','nombre' => 'P.S. SAN MIGUEL DE MITOQUERA', 'microred_id' => 9]);
        $establecimiento = Establecimiento::firstOrCreate(['codigo' => '100109309','nombre' => 'P.S. INGENIO BAJO', 'microred_id' => 9]);
        $establecimiento = Establecimiento::firstOrCreate(['codigo' => '100109310','nombre' => 'PS. SAN PEDRO CHOQUECANCHA', 'microred_id' => 9]);

        $establecimiento = Establecimiento::firstOrCreate(['codigo' => '100110201','nombre' => 'C.S. YARUMAYO', 'microred_id' => 10]);
        $establecimiento = Establecimiento::firstOrCreate(['codigo' => '100110301','nombre' => 'P.S. CHULLAY', 'microred_id' => 10]);
        $establecimiento = Establecimiento::firstOrCreate(['codigo' => '100110302','nombre' => 'P.S. TRES DE MYO - ANDAS CHICO', 'microred_id' => 10]);

        $establecimiento = Establecimiento::firstOrCreate(['codigo' => '100111201','nombre' => 'P.S. POTRACANCHA', 'microred_id' => 11]);
        $establecimiento = Establecimiento::firstOrCreate(['codigo' => '222222222','nombre' => 'C.S.M.C. VIRGILIO LOPEZ', 'microred_id' => 11]);

        $establecimiento = Establecimiento::firstOrCreate(['codigo' => '100112301','nombre' => 'P.S. YACUS', 'microred_id' => 12]);
        $establecimiento = Establecimiento::firstOrCreate(['codigo' => '100112302','nombre' => 'P.S. HUACORA', 'microred_id' => 12]);
        $establecimiento = Establecimiento::firstOrCreate(['codigo' => '100112303','nombre' => 'P.S. HUANCHAN', 'microred_id' => 12]);
        $establecimiento = Establecimiento::firstOrCreate(['codigo' => '100112304','nombre' => 'P.S. SAN ISIDRO DE PAURA', 'microred_id' => 12]);

         }
}
