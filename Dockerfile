FROM php:8.2-apache

# Cấu hình timezone và Apache rewrite
RUN a2enmod rewrite

WORKDIR /var/www/html

# Tạo file bí mật giả lập của hệ thống ngân hàng (Vault Master Key & System Config)
RUN mkdir -p /var/secret && \
    echo "VAULT_MASTER_KEY=nv_prod_sec_89f02c918b3d4f10a8c2b7405e" > /var/secret/vault_master_key.txt && \
    echo "SWIFT_GATEWAY_TOKEN=swift_auth_prod_token_991823" >> /var/secret/vault_master_key.txt && \
    chmod 644 /var/secret/vault_master_key.txt

# Phân quyền thư mục
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
