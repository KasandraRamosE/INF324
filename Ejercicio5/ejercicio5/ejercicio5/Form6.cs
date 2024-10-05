using System;
using System.Data;
using System.Data.SqlClient;
using System.Windows.Forms;

namespace ejercicio5
{
    public partial class Form6 : Form
    {
        private int idPropietario;  // Almacena el ID del propietario recibido desde Form4
        SqlConnection con;          // Conexión a la base de datos

        // Constructor que acepta el ID del propietario
        public Form6(int idPersona)
        {
            InitializeComponent();
            idPropietario = idPersona;  // Asignar el ID del propietario recibido
        }

        // Evento para cargar el formulario
        private void Form6_Load(object sender, EventArgs e)
        {
            
        }

        // Evento del botón para agregar la propiedad
        private void button1_Click(object sender, EventArgs e)
        {
            try
            {
                // Verificar que todos los campos estén llenos
                if (string.IsNullOrEmpty(textBox1.Text) || string.IsNullOrEmpty(textBox2.Text) ||
                    string.IsNullOrEmpty(textBox3.Text) || string.IsNullOrEmpty(textBox4.Text) ||
                    string.IsNullOrEmpty(textBox5.Text) || string.IsNullOrEmpty(textBox6.Text) ||
                    string.IsNullOrEmpty(textBox7.Text) || string.IsNullOrEmpty(textBox8.Text))
                {
                    MessageBox.Show("Por favor, complete todos los campos.", "Campos Vacíos", MessageBoxButtons.OK, MessageBoxIcon.Warning);
                    return;
                }

                // Inicializar la conexión a la base de datos
                con = new SqlConnection("server=(local);database=BDKasandra;Integrated Security=True;");

                // Definir el comando SQL para insertar la nueva propiedad
                string query = @"
                    INSERT INTO propiedad (id, zona, xini, yini, xfin, yfin, superficie, distrito, id_propietario)
                    VALUES (@id, @zona, @xini, @yini, @xfin, @yfin, @superficie, @distrito, @id_propietario)";

                using (SqlCommand cmd = new SqlCommand(query, con))
                {
                    // Asignar los valores de los TextBox a los parámetros del comando
                    cmd.Parameters.AddWithValue("@id", Convert.ToInt32(textBox1.Text));
                    cmd.Parameters.AddWithValue("@zona", textBox2.Text.Trim());
                    cmd.Parameters.AddWithValue("@xini", Convert.ToDecimal(textBox3.Text));
                    cmd.Parameters.AddWithValue("@yini", Convert.ToDecimal(textBox4.Text));
                    cmd.Parameters.AddWithValue("@xfin", Convert.ToDecimal(textBox5.Text));
                    cmd.Parameters.AddWithValue("@yfin", Convert.ToDecimal(textBox6.Text));
                    cmd.Parameters.AddWithValue("@superficie", Convert.ToDecimal(textBox7.Text));
                    cmd.Parameters.AddWithValue("@distrito", textBox8.Text.Trim());
                    cmd.Parameters.AddWithValue("@id_propietario", idPropietario);  // Usar el ID del propietario recibido

                    // Abrir la conexión y ejecutar el comando
                    con.Open();
                    cmd.ExecuteNonQuery();
                    con.Close();

                    MessageBox.Show("Propiedad añadida con éxito.", "Inserción Exitosa", MessageBoxButtons.OK, MessageBoxIcon.Information);

                    // Cerrar el formulario después de la inserción exitosa
                    this.Close();

                }
            }
            catch (Exception ex)
            {
                MessageBox.Show("Error al agregar la propiedad: " + ex.Message, "Error", MessageBoxButtons.OK, MessageBoxIcon.Error);
                if (con != null && con.State == System.Data.ConnectionState.Open)
                {
                    con.Close();
                }
            }
        }

        // Método para limpiar los TextBox después de la inserción
        private void LimpiarTextBoxes()
        {
            textBox1.Clear();
            textBox2.Clear();
            textBox3.Clear();
            textBox4.Clear();
            textBox5.Clear();
            textBox6.Clear();
            textBox7.Clear();
            textBox8.Clear();
        }
    }
}
