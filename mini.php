package com.example.fullauto;

import org.w3c.dom.*;
import javax.xml.parsers.*;
import java.io.*;
import java.net.HttpURLConnection;
import java.net.URL;
import java.nio.charset.StandardCharsets;

/**
 * Ejemplo de "traducción" del plugin PHP/WordPress a un programa Java independiente.
 */
public class FullAutomaticWhatsApp {

    // ------------------------------------------------------------------------
    // 1) XML incrustado (mismo contenido que en el plugin original).
    // ------------------------------------------------------------------------
    private static final String FULL_AUTO_XML = ""
        <plugin>\n"
          <security>\n"
            <check><![CDATA[\n"
        if (!defined('ABSPATH')) {\n"
          exit; // Salir si se accede directamente.\n"
        }\n"
            ]]></check>\n"
          </security>\n"
          <admin>\n"
            <enqueueStyles>\n"
              <function>whatsapp_enqueue_styles</function>\n"

// --------- MAIN_LOGIC ---------

// --------- MAIN_LOGIC ---------
    // 9) MAIN: Ejemplo de uso
    // ------------------------------------------------------------------------
    public static void main(String[] args) {
        // (A) Leer el XML incrustado y setear config por defecto
        parseEmbeddedXml();

        // (B) Simular que “alguien” sobrescribe la configuración real
        //     (porque en WordPress se guardaría en la base de datos).
        // Por ejemplo:
        config.accessToken = "TU_TOKEN_DE_ACCESO_DE_FACEBOOK";
        config.phoneId     = "1234567890000";
        config.adminPhone  = "5491123456789";  // sin "+"
        // Si deseas, cambia vendorMsg, customerMsg, etc.

        // (C) Llamar hooks de ciclo de vida
        onPluginActivate();
        onPluginInit();

        // (D) Simular un pedido y cambio de estado
        Order newOrder = new Order(
            1001,                // ID del pedido
            999.99,              // total
            "5491198765432",     // teléfono del cliente
            "Producto A x 2, Producto B x 1"
        );

        String oldStatus = "pending";
        String newStatus = "processing"; // disparará notificación al vendedor
        onOrderStatusChange(newOrder, oldStatus, newStatus);

        // Otro cambio de estado que ahora sea "completed" para notificar al cliente:
        oldStatus = newStatus;
        newStatus = "completed";
        onOrderStatusChange(newOrder, oldStatus, newStatus);

        // (E) Simular desinstalación
        onPluginUninstall();
    }

    // ------------------------------------------------------------------------
    // Utilidades varias
    // ------------------------------------------------------------------------
    /**
     * Convierte un InputStream en un String (para leer respuestas HTTP).
     */
    private static String convertStreamToString(InputStream is) throws IOException {
        BufferedReader reader = new BufferedReader(new InputStreamReader(is, StandardCharsets.UTF_8));
        StringBuilder sb = new StringBuilder();
        String line;
        while ((line = reader.readLine()) != null) {
            sb.append(line);
        }
        return sb.toString();
    }

    /**
     * Escapa caracteres conflictivos en JSON.
     */
    private static String escapeJson(String text) {
        // Pequeño reemplazo de comillas, saltos de línea, etc.
        // (No es un escape completo, pero sirve de ejemplo)
        return text
            .replace("\\", "\\\\")
            .replace("\"", "\\\"")
            .replace("\n", "\\n")
            .replace("\r", "\\r");
    }
}

// --------- USER_MANAGEMENT ---------

// --------- USER_MANAGEMENT ---------
          <settings>\n"
            <setting name=\"access_token\" type=\"text\" required=\"true\">\n"
          </settings>\n"
          <functions>\n"
            <function name=\"whatsapp_send\">\n"
              <description>Función global para enviar mensajes a un teléfono vía WhatsApp Cloud.</description>\n"
            </function>\n"
            <function name=\"whatsapp_init\">\n"
              <description>Inicializa el plugin (hook: plugins_loaded).</description>\n"
            </function>\n"
            <function name=\"whatsapp_register_menu\">\n"
              <description>Registra el submenú en WooCommerce (hook: admin_menu).</description>\n"
            </function>\n"
            <function name=\"whatsapp_options_page\">\n"
              <description>Muestra la página de configuración y guarda las opciones.</description>\n"
            </function>\n"
            <function name=\"whatsapp_activate\">\n"
              <description>Función de activación (register_uninstall_hook).</description>\n"
            </function>\n"
            <function name=\"whatsapp_uninstall\">\n"
              <description>Elimina las opciones de la BD.</description>\n"
            </function>\n"
            <function name=\"whatsapp_status_changed\">\n"
              <description>Hook al cambiar estado de pedido. Envía notificaciones a vendedor y/o cliente.</description>\n"
            </function>\n"
            <function name=\"whatsapp_enqueue_styles\">\n"
            conn.setRequestProperty("Authorization", "Bearer " + config.accessToken);
            conn.setRequestProperty("Content-Type", "application/json; charset=UTF-8");

            // 6.4) Cuerpo JSON
            // Ejemplo JSON:
            // {
            //   "messaging_product":"whatsapp",
            //   "to":"<phoneNumber>",
            //   "type":"text",
            // Ejemplo: leer <settings> -> <setting> con name=...
            NodeList settingList = doc.getElementsByTagName("setting");
            for (int i = 0; i < settingList.getLength(); i++) {
                Node node = settingList.item(i);
                if (node.getNodeType() == Node.ELEMENT_NODE) {
                    Element elem = (Element) node;
                    String nameAttr = elem.getAttribute("name");
                    String defaultValue = "";
                    String required = elem.getAttribute("required");

                    // Leer <default> si existe
                    NodeList defaultNodes = elem.getElementsByTagName("default");
                    if (defaultNodes.getLength() > 0) {
                        // se asume un solo <default>...
                        defaultValue = defaultNodes.item(0).getTextContent().trim();
                    }

                    // *** En un plugin real, leeríamos la opción real en BD.
                    // Aquí asignamos valores “por defecto” simulados:
                    if ("access_token".equals(nameAttr)) {
                        config.accessToken = defaultValue; // si existiera
                    } else if ("phone_id".equals(nameAttr)) {
                        config.phoneId = defaultValue;
                    } else if ("admin_phone".equals(nameAttr)) {
                        config.adminPhone = defaultValue;
                    } else if ("vendor_status".equals(nameAttr)) {
                        if (!defaultValue.isEmpty()) {
                            config.vendorStatus = defaultValue;
                        }
                    } else if ("vendor_msg".equals(nameAttr)) {
                        if (!defaultValue.isEmpty()) {
                            config.vendorMsg = defaultValue;
                        }
                    } else if ("customer_status".equals(nameAttr)) {
                        if (!defaultValue.isEmpty()) {
                            config.customerStatus = defaultValue;
                        }
                    } else if ("customer_msg".equals(nameAttr)) {
                        if (!defaultValue.isEmpty()) {
                            config.customerMsg = defaultValue;
                        }
                    }
                }
            }

            System.out.println("[parseEmbeddedXml] XML leído. Config en memoria (por defecto).");
        } catch (Exception e) {
            e.printStackTrace();
            System.out.println("[parseEmbeddedXml] Error al parsear XML incrustado.");
        }
    }

    // ------------------------------------------------------------------------

// --------- MESSAGING ---------

// --------- MESSAGING ---------
    public static void sendWhatsApp(String phoneNumber, String message) {
        if (phoneNumber == null || phoneNumber.isEmpty()) {
            System.out.println("[sendWhatsApp] PhoneNumber vacío, no se envía nada.");
            return;
        }

        System.out.println("[sendWhatsApp] Enviando mensaje a " + phoneNumber + ": " + message);

        try {
            // 6.1) Preparar URL
            String urlStr = "https://graph.facebook.com/v18.0/" + config.phoneId + "/messages";
            URL url = new URL(urlStr);

            // 6.2) Crear conexión HTTP
            HttpURLConnection conn = (HttpURLConnection) url.openConnection();
            //   "text":{"body":"<message>"}
            // }
            String jsonBody = "{\"messaging_product\":\"whatsapp\",\"to\":\"" + phoneNumber + "\","
                + "\"type\":\"text\",\"text\":{\"body\":\"" + escapeJson(message) + "\"}}";

            // 6.5) Enviar el JSON
            byte[] out = jsonBody.getBytes(StandardCharsets.UTF_8);
            conn.getOutputStream().write(out);

            // 6.6) Leer respuesta
            int status = conn.getResponseCode();
            if (status == HttpURLConnection.HTTP_OK ||
                status == HttpURLConnection.HTTP_CREATED ||
                status == 200) {
                System.out.println("[sendWhatsApp] Mensaje enviado con éxito a " + phoneNumber);
            } else {
                System.out.println("[sendWhatsApp] Error al enviar. Código HTTP: " + status);
                try (InputStream errorStream = conn.getErrorStream()) {
                    if (errorStream != null) {
                        String errResponse = convertStreamToString(errorStream);
                        System.out.println("[sendWhatsApp] Respuesta de error: " + errResponse);
                    }
                }
            }

            conn.disconnect();
        } catch (Exception e) {
            System.err.println("[sendWhatsApp] Error: " + e.getMessage());
            e.printStackTrace();
        }
    }

    /**
     * Reemplaza placeholders en el mensaje, como {NUM}, {SUM}, {NEW_STATUS}, etc.
     */
    public static String replacePlaceholders(String message, Order order, String oldStatus, String newStatus) {
        return message
            .replace("{NUM}", String.valueOf(order.getOrderId()))
            .replace("{SUM}", String.valueOf(order.getTotal()))
            .replace("{NEW_STATUS}", newStatus)
            .replace("{OLD_STATUS}", oldStatus)
            .replace("{ITEMS}", order.getItemsString());
        // Se podría expandir con más placeholders...
    }

    // ------------------------------------------------------------------------
    // 7) Simulación de un "Order" (como en WooCommerce)
    // ------------------------------------------------------------------------
    public static class Order {
        private int orderId;
        private double total;
        private String billingPhone;
        private String itemsString; // "Producto A x 1, Producto B x 2", etc.

        public Order(int orderId, double total, String billingPhone, String itemsString) {
            this.orderId = orderId;
            this.total = total;
            this.billingPhone = billingPhone;
            this.itemsString = itemsString;
        }

        public int getOrderId() {
            return orderId;
        }

        public double getTotal() {
            return total;
        }

        public String getBillingPhone() {
            return billingPhone;
        }

        public String getItemsString() {
            return itemsString;
        }
    }

    // ------------------------------------------------------------------------
    // 8) Métodos para parsear el XML incrustado y leer la configuración.
    //    (En WordPress se hacía vía "simplexml_load_string" + get_option, etc.)
    // ------------------------------------------------------------------------
    public static void parseEmbeddedXml() {
        try {
            DocumentBuilderFactory dbf = DocumentBuilderFactory.newInstance();
            DocumentBuilder db = dbf.newDocumentBuilder();
            InputStream is = new ByteArrayInputStream(FULL_AUTO_XML.getBytes(StandardCharsets.UTF_8));
            Document doc = db.parse(is);
            doc.getDocumentElement().normalize();


// --------- SECURITY ---------

// --------- SECURITY ---------
              <description>Token de acceso de la API WhatsApp Cloud (Facebook Developers).</description>\n"
            </setting>\n"
            <setting name=\"phone_id\" type=\"text\" required=\"true\">\n"
              <description>Phone Number ID de tu WhatsApp empresarial (formato numérico).</description>\n"
            </setting>\n"
            <setting name=\"admin_phone\" type=\"text\" required=\"true\">\n"
              <description>Teléfono del administrador (con código de país, sin '+').</description>\n"
            </setting>\n"
            <setting name=\"vendor_status\" type=\"text\">\n"
              <default>processing</default>\n"
              <description>Estado del pedido que notifica al vendedor.</description>\n"
            </setting>\n"
            <setting name=\"vendor_msg\" type=\"textarea\">\n"
              <default><![CDATA[Nuevo pedido: {NUM}, Total: {SUM}]]></default>\n"
              <description>Mensaje para el vendedor. Placeholders: {NUM}, {SUM}, etc.</description>\n"
            </setting>\n"
            <setting name=\"customer_status\" type=\"text\">\n"
              <default>completed</default>\n"
              <description>Estado del pedido que notifica al cliente.</description>\n"
            </setting>\n"
            <setting name=\"customer_msg\" type=\"textarea\">\n"
              <default><![CDATA[Su pedido {NUM} ha sido {NEW_STATUS}]]></default>\n"
              <description>Mensaje para el cliente. Placeholders: {NUM}, {NEW_STATUS}.</description>\n"
            </setting>\n"
    // 2) Objeto para almacenar configuración relevante: token, phoneID, etc.
    // ------------------------------------------------------------------------
    public static class WhatsAppConfig {
        public String accessToken    = "";
        public String phoneId        = "";
        public String adminPhone     = "";
        public String vendorStatus   = "processing";
        public String vendorMsg      = "Nuevo pedido: {NUM}, Total: {SUM}";
        public String customerStatus = "completed";
        public String customerMsg    = "Su pedido {NUM} ha sido {NEW_STATUS}";
    }

    // Configuración en memoria
    private static WhatsAppConfig config = new WhatsAppConfig();

    // ------------------------------------------------------------------------
    // 3) Ciclo de vida: Activación y Desinstalación (simulación)
    // ------------------------------------------------------------------------
    public static void onPluginActivate() {
        System.out.println("[ACTIVATION] El plugin está siendo activado. (Simulación)");
        // Aquí se podrían inicializar valores por defecto o migraciones
    }

    public static void onPluginUninstall() {
        System.out.println("[UNINSTALL] Eliminando opciones de la BD (simulado).");
        // Borraríamos "opciones" guardadas, en este ejemplo lo omitimos
    }

    // ------------------------------------------------------------------------
    // 4) Inicialización (equivalente a `whatsapp_init`)
    // ------------------------------------------------------------------------
    public static void onPluginInit() {
        // Comprobaríamos la existencia de algo necesario; simulamos
        System.out.println("[INIT] Plugin inicializado. (Simulación)");
    }

    // ------------------------------------------------------------------------
    // 5) Función clave: al cambiar estado de pedido (status_changed)
    // ------------------------------------------------------------------------
    /**
     * Simula la lógica principal de notificación:
     * - Se notifica al vendedor si el nuevo estado coincide con vendorStatus
     * - Se notifica al cliente si el nuevo estado coincide con customerStatus
     */
    public static void onOrderStatusChange(Order order, String oldStatus, String newStatus) {
        if (config.accessToken.isEmpty() || config.phoneId.isEmpty()) {
            System.out.println("[onOrderStatusChange] Faltan datos (accessToken o phoneId).");
            return;
        }

        // Notificar vendedor
        if (newStatus.equalsIgnoreCase(config.vendorStatus)) {
            String msgVendor = replacePlaceholders(config.vendorMsg, order, oldStatus, newStatus);
            sendWhatsApp(config.adminPhone, msgVendor);
        }

        // Notificar cliente
        if (newStatus.equalsIgnoreCase(config.customerStatus)) {
            String customerPhone = order.getBillingPhone();
            if (customerPhone != null && !customerPhone.isEmpty()) {
                String msgCustomer = replacePlaceholders(config.customerMsg, order, oldStatus, newStatus);
                sendWhatsApp(customerPhone, msgCustomer);
            }
        }
    }

    // ------------------------------------------------------------------------


// --------- API ---------
// --------- API ---------
    // 6) Lógica de envío a la API de WhatsApp Cloud
    // ------------------------------------------------------------------------

// --------- UI_UX ---------

// --------- UI_UX ---------
              <file>styles/style.css</file>\n"
              <description>Encola un archivo CSS en el área de administración, si existe.</description>\n"
            </enqueueStyles>\n"
            <menu>\n"
              <parent>woocommerce</parent>\n"
              <title>WhatsApp Notificaciones</title>\n"
              <menu_title>WhatsApp Notif.</menu_title>\n"
              <capability>manage_woocommerce</capability>\n"
              <slug>whatsapp_settings</slug>\n"
              <callback>whatsapp_options_page</callback>\n"
              <description>Subpágina en el menú de WooCommerce para configurar el plugin.</description>\n"
            </menu>\n"
          </admin>\n"
          <lifecycle>\n"
            <activation>\n"
              <function>whatsapp_activate</function>\n"
              <description>Registra la función de desinstalación al activar el plugin.</description>\n"
            </activation>\n"
            <uninstall>\n"
              <function>whatsapp_uninstall</function>\n"
              <description>Elimina las opciones de la base de datos al desinstalar.</description>\n"
              <actions>\n"
                <action>delete_option('whatsapp_access_token')</action>\n"
                <action>delete_option('whatsapp_phone_id')</action>\n"
                <action>delete_option('whatsapp_admin_phone')</action>\n"
                <action>delete_option('whatsapp_vendor_status')</action>\n"
                <action>delete_option('whatsapp_vendor_msg')</action>\n"
                <action>delete_option('whatsapp_customer_status')</action>\n"
                <action>delete_option('whatsapp_customer_msg')</action>\n"
              </actions>\n"
            </uninstall>\n"
          </lifecycle>\n"
          <hooks>\n"
            <hook name=\"plugins_loaded\">\n"
              <callback>whatsapp_init</callback>\n"
              <description>Inicializa el plugin una vez cargados todos los plugins, incluido WooCommerce.</description>\n"
            </hook>\n"
            <hook name=\"admin_enqueue_scripts\">\n"
              <callback>whatsapp_enqueue_styles</callback>\n"
              <description>Carga los estilos de administración.</description>\n"
            </hook>\n"
            <hook name=\"admin_menu\">\n"
              <callback>whatsapp_register_menu</callback>\n"
              <description>Agrega la subpágina de configuración en el menú WooCommerce.</description>\n"
            </hook>\n"
            <hook name=\"woocommerce_checkout_order_processed\">\n"
              <callback>whatsapp_status_changed</callback>\n"
              <parameters>order_id</parameters>\n"
              <description>Se ejecuta al procesar un pedido nuevo.</description>\n"
            </hook>\n"
            <hook name=\"woocommerce_order_status_changed\">\n"
              <callback>whatsapp_status_changed</callback>\n"
              <parameters>order_id, old_status, new_status</parameters>\n"
              <description>Se ejecuta al cambiar el estado de un pedido existente.</description>\n"
            </hook>\n"
          </hooks>\n"
              <description>Encola los estilos si existe 'styles/style.css'.</description>\n"
            </function>\n"
          </functions>\n"
        </plugin>\n";

    // ------------------------------------------------------------------------

// --------- SOCIAL_FEATURES ---------

// --------- SOCIAL_FEATURES ---------
            conn.setRequestMethod("POST");
            conn.setConnectTimeout(15000);  // 15 seg
            conn.setReadTimeout(15000);     // 15 seg
            conn.setDoOutput(true);

            // 6.3) Cabeceras


