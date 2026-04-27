<div class="wp-block-group mt-3 mb-3 alignfull is-style-margin-vertical--top is-layout-flow wp-block-group-is-layout-flow" style="border-radius:0px;padding-right:var(--wp--preset--spacing--10);padding-left:var(--wp--preset--spacing--10)">
    <div class="wp-block-group full-width has-neutral-30-background-color has-background has-global-padding is-layout-constrained wp-container-core-group-is-layout-306daf7c wp-block-group-is-layout-constrained" style="border-radius:32px;padding-top:0;padding-right:var(--wp--preset--spacing--10);padding-bottom:0;padding-left:var(--wp--preset--spacing--10)">
        <div class="wp-block-group is-style-margin-vertical is-layout-flow wp-block-group-is-layout-flow">
                
            <?php
                // Array de todos los campos ACF a mostrar
                $acf_fields = [
                    'eess_cafeteria' => 'Cafetería',
                    'eess_carga_electrica' => 'Carga Eléctrica',
                    'eess_combustible' => 'Combustible',
                    'eess_tienda' => 'Tienda',
                    'eess_lavado_vehiculos' => 'Lavado de Vehículos'
                ];
            ?>
    
            <div class="estacion-services-grid---">
                <div class="mb-1">Estación de Servicio:
                    <?php
                        the_field( 'eess_petrolera' );
                    ?>
                </div>
                

            </div>	
            <div class="estacion-services-grid">
                <?php foreach ($acf_fields as $field_name => $field_title) : 
                    // Obtener el objeto del campo para acceder a las etiquetas
                    $field_object = get_field_object($field_name);
                    $selected_values = get_field($field_name);
                    
                    // Mostrar las etiquetas si hay alguna
                    if ($field_object && $selected_values && is_array($selected_values) && !empty($selected_values)) : ?>
                    <div class="estacion-service-section">
                        <p class="has-caption-font-size has-neutral-60-color uppercase"><strong><?php echo esc_html($field_title); ?></strong></p>
                        <ul class="estacion-service-list">
                            <?php foreach ($selected_values as $value) : ?>
                                <?php if (!empty($value) && isset($field_object['choices'][$value])) : 
                                    // Ruta al archivo de icono
                                    $icon_path = get_template_directory() . '/assets/icons/' . $value . '.svg';
                                ?>
                                    <li>
                                        <?php if (file_exists($icon_path)) : ?>
                                            <?php echo file_get_contents($icon_path); ?>
                                        <?php endif; ?>
                                        <?php echo esc_html($field_object['choices'][$value]); ?>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>	
            
        </div>
    </div>
</div>