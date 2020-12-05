CREATE TABLE "usuario" (
    "id_usuario" INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
    "apellido" TEXT NOT NULL,
    "nombre" TEXT NOT NULL,
    "email" TEXT NOT NULL UNIQUE,
    "password" TEXT NOT NULL,
    "perfil" TEXT NOT NULL DEFAULT "USUARIO" CHECK("perfil" IN("ADMIN", "USUARIO")),
    "created" DATETIME NOT NULL,
    "last_modified" DATETIME NOT NULL,
    "deleted" INTEGER NOT NULL DEFAULT 0 CHECK("deleted" IN(0, 1))
);
CREATE INDEX idx_usuario_email ON usuario (email);