using System;
using System.Data;
using System.Data.SqlClient;
using System.Windows.Forms;

namespace ejercicio7
{
    public partial class Form2 : Form
    {
        // Conexión a la base de datos
        SqlConnection con = new SqlConnection("server=(local);database=BDKasandra;Integrated Security=True;");

        public Form2()
        {
            InitializeComponent();
            CargarDatosImpuestos(); // Cargar los datos en el DataGridView al iniciar
        }

        // Método para cargar las personas con sus propiedades por tipo de impuesto en el DataGridView usando PIVOT
        private void CargarDatosImpuestos()
        {
            try
            {
                con.Open();

                // Consulta PIVOT SQL para mostrar los nombres según tipo de impuesto
                string sql = @"
                    SELECT 
                        [Alto] AS Impuesto_Alto,
                        [Medio] AS Impuesto_Medio,
                        [Bajo] AS Impuesto_Bajo
                    FROM 
                    (
                        SELECT distinct
                            p.nombre + ' ' + p.paterno + ' ' + p.materno AS NombreCompleto,
                            CASE 
                                WHEN LEFT(CAST(pr.id AS VARCHAR), 1) = '1' THEN 'Alto'
                                WHEN LEFT(CAST(pr.id AS VARCHAR), 1) = '2' THEN 'Medio'
                                WHEN LEFT(CAST(pr.id AS VARCHAR), 1) = '3' THEN 'Bajo'
                            END AS TipoImpuesto,
                            ROW_NUMBER() OVER(PARTITION BY LEFT(CAST(pr.id AS VARCHAR), 1) ORDER BY p.nombre) AS RowNum
                        FROM persona p
                        INNER JOIN propiedad pr ON p.id = pr.id_propietario
                    ) AS SourceTable
                    PIVOT 
                    (
                        MAX(NombreCompleto) 
                        FOR TipoImpuesto IN ([Alto], [Medio], [Bajo])
                    ) AS PivotTable
                    ORDER BY RowNum;
                ";

                // Cargar los datos en un DataTable usando SqlDataAdapter
                SqlDataAdapter da = new SqlDataAdapter(sql, con);
                DataTable dt = new DataTable();
                da.Fill(dt);

                // Asignar el DataTable como fuente de datos del DataGridView
                dataGridView1.DataSource = dt;
            }
            catch (Exception ex)
            {
                MessageBox.Show("Error al cargar los datos: " + ex.Message);
            }
            finally
            {
                // Asegurar que la conexión se cierra en cualquier caso
                con.Close();
            }
        }
    }
}
