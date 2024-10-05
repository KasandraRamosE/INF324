using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Data.SqlClient;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace ejercicio5
{
    public partial class Form5 : Form
    {
        public Form5()
        {
            InitializeComponent();
        }

        SqlConnection con = new SqlConnection("server=(local);database=BDKasandra;Integrated Security=True;");
        private int idUsuario;  // Almacena el ID del usuario actual

        // Constructor que acepta el ID del usuario
        public Form5(int idUsuario)
        {
            InitializeComponent();
            this.idUsuario = idUsuario;  // Asignar el ID del usuario recibido
            CargarDatos(); // Cargar las propiedades al inicializar el formulario
        }

        // Método para cargar las propiedades del usuario actual en el DataGridView
        private void CargarDatos()
        {
            try
            {
                // Definir la consulta para obtener las propiedades del usuario actual
                string query = "SELECT id, zona, xini, yini, xfin, yfin, superficie, distrito FROM propiedad WHERE id_propietario=@idPropietario";

                SqlCommand cmd = new SqlCommand(query, con);
                cmd.Parameters.AddWithValue("@idPropietario", idUsuario);

                SqlDataAdapter da = new SqlDataAdapter(cmd);
                DataTable dt = new DataTable();

                // Abrir la conexión y llenar el DataTable con los resultados de la consulta
                con.Open();
                da.Fill(dt);

                // Asignar el DataTable como la fuente de datos del DataGridView
                dataGridView1.DataSource = dt;

                // Cerrar la conexión
                con.Close();
            }
            catch (Exception ex)
            {
                MessageBox.Show("Error al cargar los datos: " + ex.Message);
            }
        }

        // Evento que se dispara al seleccionar una fila en el DataGridView
        private void dataGridView1_SelectionChanged(object sender, EventArgs e)
        {
            // Verificar que haya filas seleccionadas en el DataGridView
            if (dataGridView1.SelectedRows.Count > 0)
            {
                try
                {
                    // Obtener el ID de la propiedad seleccionada
                    string propiedadId = dataGridView1.SelectedRows[0].Cells["id"].Value.ToString();

                    // Determinar el tipo de impuesto en función del primer dígito del ID
                    string tipoImpuesto = ObtenerTipoImpuesto(propiedadId);

                    // Mostrar el tipo de impuesto en el Label2
                    label2.Text = "Tipo de Impuesto: " + tipoImpuesto;
                }
                catch (Exception ex)
                {
                    MessageBox.Show("Error al procesar la fila seleccionada: " + ex.Message);
                }
            }
        }

        // Método para determinar el tipo de impuesto basado en el primer dígito del ID de la propiedad
        private string ObtenerTipoImpuesto(string propiedadId)
        {
            // Obtener el primer carácter del ID de la propiedad
            char primerDigito = propiedadId[0];

            // Determinar el tipo de impuesto en función del primer carácter
            switch (primerDigito)
            {
                case '1':
                    return "Alto";
                case '2':
                    return "Medio";
                case '3':
                    return "Bajo";
                default:
                    return "Desconocido";
            }
        }
    }
}
