import java.io.IOException;
import java.io.PrintWriter;
import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

@WebServlet(urlPatterns = {"/servlet"})
public class servlet extends HttpServlet {

    protected void processRequest(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        response.setContentType("text/html;charset=UTF-8");

        // Obtener el código catastral enviado desde el formulario
        String idCatastro = request.getParameter("id_catastro");

        // Variable para almacenar el tipo de impuesto
        String tipoImpuesto = "";

        // Generar la respuesta HTML
        try (PrintWriter out = response.getWriter()) {
            out.println("<!DOCTYPE html>");
            out.println("<html>");
            out.println("<head>");
            out.println("<title>Evaluación de Impuesto</title>");
            
            // Definir estilos en línea para el diseño
            out.println("<style>");
            out.println("body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 20px; text-align: center; }");
            out.println(".container { background-color: white; width: 60%; margin: 50px auto; padding: 20px; box-shadow: 0px 0px 15px rgba(0,0,0,0.2); border-radius: 8px; }");
            out.println("h2 { color: #333; }");
            out.println("p { font-size: 18px; color: #555; }");
            out.println(".btn { display: inline-block; padding: 10px 20px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 5px; margin-top: 20px; }");
            out.println(".btn:hover { background-color: #45a049; }");
            out.println("</style>");
            
            out.println("</head>");
            out.println("<body>");
            out.println("<div class='container'>");
            out.println("<h2>Evaluación de Tipo de Impuesto</h2>");

            try {
                // Verificar si el código catastral está disponible y no es vacío
                if (idCatastro != null && !idCatastro.isEmpty()) {
                    char primerCaracter = idCatastro.charAt(0);

                    // Determinar el tipo de impuesto basado en el primer carácter del código
                    tipoImpuesto = switch (primerCaracter) {
                        case '1' -> "Impuesto Alto";
                        case '2' -> "Impuesto Medio";
                        case '3' -> "Impuesto Bajo";
                        default -> "Tipo de Impuesto Desconocido";
                    };

                    // Mostrar los resultados
                    out.println("<p>Código Catastral: <strong>" + idCatastro + "</strong></p>");
                    out.println("<p>Tipo de Impuesto: <strong style='color: #ff5722;'>" + tipoImpuesto + "</strong></p>");
                } else {
                    out.println("<h2 style='color: red;'>Código catastral no proporcionado.</h2>");
                }
            } catch (Exception e) {
                // Manejar cualquier error de formato o acceso
                out.println("<h2 style='color: red;'>Error en el formato del código catastral.</h2>");
            }

            // Botón para volver a la página principal
            out.println("<br><a href='http://localhost/examen324/1%20y%202/catastro.php/' class='btn'>Volver</a>");
            out.println("</div>");
            out.println("</body>");
            out.println("</html>");
        }
    }

    @Override
    protected void doGet(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        processRequest(request, response);
    }

    @Override
    protected void doPost(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        processRequest(request, response);
    }

    @Override
    public String getServletInfo() {
        return "Evaluación del Tipo de Impuesto de la Propiedad";
    }
}
