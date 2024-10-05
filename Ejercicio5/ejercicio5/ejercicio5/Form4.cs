using System;
using System.Data;
using System.Data.SqlClient;
using System.Windows.Forms;

namespace ejercicio5
{
    public partial class Form4 : Form
    {
        DataSet ds = new DataSet();  // Crear un DataSet para manejar los datos
        SqlDataAdapter adaPersona;   // SqlDataAdapter para la tabla persona
        SqlConnection con;           // Conexión a la base de datos

        public Form4()
        {
            InitializeComponent();
            dataGridView1.RowValidated += dataGridView1_RowValidated;
        }

        private void Form4_Load(object sender, EventArgs e)
        {
            CargarDatosPersona();
        }

        private void CargarDatosPersona()
        {
            try
            {
                con = new SqlConnection("server=(local);database=BDKasandra;Integrated Security=True;");
                string query = "SELECT id, ci, nombre, paterno, materno, usuario, contraseña FROM persona";
                adaPersona = new SqlDataAdapter(query, con);
                SqlCommandBuilder builderPersona = new SqlCommandBuilder(adaPersona);
                adaPersona.MissingSchemaAction = MissingSchemaAction.AddWithKey;
                adaPersona.Fill(ds, "persona");

                dataGridView1.DataSource = ds;
                dataGridView1.DataMember = "persona";
                dataGridView1.Columns["id"].Visible = false;
            }
            catch (Exception ex)
            {
                MessageBox.Show("Error al cargar los datos: " + ex.Message, "Error", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }

        private void dataGridView1_RowValidated(object sender, DataGridViewCellEventArgs e)
        {
            dataGridView1.EndEdit();
            GuardarCambiosPersona();
        }

        private void GuardarCambiosPersona()
        {
            try
            {
                if (ds.Tables["persona"].GetChanges() != null)
                {
                    adaPersona.Update(ds, "persona");
                    ds.Tables["persona"].AcceptChanges();
                    MessageBox.Show("Cambios guardados en la tabla persona", "Información", MessageBoxButtons.OK, MessageBoxIcon.Information);
                }
            }
            catch (DBConcurrencyException ex)
            {
                MessageBox.Show("Error de concurrencia: " + ex.Message, "Error", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
            catch (Exception ex)
            {
                MessageBox.Show("Error al guardar los cambios: " + ex.Message, "Error", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }

        // Evento para eliminar un registro existente
        private void button1_Click(object sender, EventArgs e)
        {
            try
            {
                if (dataGridView1.SelectedRows.Count > 0)
                {
                    int filaSeleccionada = dataGridView1.SelectedRows[0].Index;
                    int idPersona = Convert.ToInt32(dataGridView1.Rows[filaSeleccionada].Cells["id"].Value);

                    var confirmResult = MessageBox.Show("¿Está seguro de que desea eliminar este propietario?", "Confirmar eliminación", MessageBoxButtons.YesNo, MessageBoxIcon.Warning);
                    if (confirmResult != DialogResult.Yes) return;

                    ds.Tables["persona"].Rows[filaSeleccionada].Delete();
                    adaPersona.Update(ds, "persona");
                    ds.Tables["persona"].AcceptChanges();

                    MessageBox.Show("Propietario eliminado con éxito.", "Eliminación Exitosa", MessageBoxButtons.OK, MessageBoxIcon.Information);
                }
                else
                {
                    MessageBox.Show("Seleccione una fila para eliminar.", "Advertencia", MessageBoxButtons.OK, MessageBoxIcon.Warning);
                }
            }
            catch (Exception ex)
            {
                MessageBox.Show("Error al eliminar el propietario: " + ex.Message, "Error", MessageBoxButtons.OK, MessageBoxIcon.Error);
                con.Close();
            }
        }

        // Evento para insertar un nuevo registro al hacer clic en button2
        private void button2_Click(object sender, EventArgs e)
        {
            try
            {
                // Validar que todos los TextBox estén llenos
                if (string.IsNullOrEmpty(textBox1.Text) || string.IsNullOrEmpty(textBox2.Text) ||
                    string.IsNullOrEmpty(textBox3.Text) || string.IsNullOrEmpty(textBox4.Text) ||
                    string.IsNullOrEmpty(textBox5.Text) || string.IsNullOrEmpty(textBox6.Text))
                {
                    MessageBox.Show("Por favor, complete todos los campos.", "Campos Vacíos", MessageBoxButtons.OK, MessageBoxIcon.Warning);
                    return;
                }

                // Crear una nueva fila para la tabla persona
                DataRow nuevaFila = ds.Tables["persona"].NewRow();
                nuevaFila["ci"] = textBox1.Text.Trim();
                nuevaFila["nombre"] = textBox2.Text.Trim();
                nuevaFila["paterno"] = textBox3.Text.Trim();
                nuevaFila["materno"] = textBox4.Text.Trim();
                nuevaFila["usuario"] = textBox5.Text.Trim();
                nuevaFila["contraseña"] = textBox6.Text.Trim();

                // Generar un nuevo ID único (puedes personalizar esto según sea necesario)
                nuevaFila["id"] = ObtenerNuevoId();

                // Agregar la nueva fila al DataSet
                ds.Tables["persona"].Rows.Add(nuevaFila);

                // Actualizar la base de datos con el nuevo registro
                adaPersona.Update(ds, "persona");
                ds.Tables["persona"].AcceptChanges();

                MessageBox.Show("Nuevo propietario agregado con éxito.", "Inserción Exitosa", MessageBoxButtons.OK, MessageBoxIcon.Information);

                // Limpiar los TextBox después de la inserción
                LimpiarTextBoxes();
            }
            catch (Exception ex)
            {
                MessageBox.Show("Error al agregar el nuevo propietario: " + ex.Message, "Error", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }

        // Método para obtener un nuevo ID único para el registro
        private int ObtenerNuevoId()
        {
            if (ds.Tables["persona"].Rows.Count > 0)
            {
                return Convert.ToInt32(ds.Tables["persona"].Compute("MAX(id)", "")) + 1;
            }
            else
            {
                return 1;
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
        }

        private void button3_Click(object sender, EventArgs e)
        {
            try
            {
                // Verificar que haya una fila seleccionada
                if (dataGridView1.SelectedRows.Count > 0)
                {
                    // Obtener el ID de la persona seleccionada
                    int filaSeleccionada = dataGridView1.SelectedRows[0].Index;
                    int idPersona = Convert.ToInt32(dataGridView1.Rows[filaSeleccionada].Cells["id"].Value);

                    // Abrir el Form6 y pasar el ID de la persona como parámetro
                    Form6 form6 = new Form6(idPersona);
                    form6.Show();  // Mostrar el Form6
                }
                else
                {
                    MessageBox.Show("Seleccione una fila para añadir una propiedad a la persona.", "Advertencia", MessageBoxButtons.OK, MessageBoxIcon.Warning);
                }
            }
            catch (Exception ex)
            {
                MessageBox.Show("Error al abrir el formulario de propiedades: " + ex.Message, "Error", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }

    }
}
