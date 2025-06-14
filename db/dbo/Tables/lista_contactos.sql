-- =====================================================
-- Object:  Table [dbo].[lista_contactos]
-- Script Date: 19/4/2025 11:40:26
-- =====================================================

CREATE TABLE [dbo].[lista_contactos](
    [id] [int] IDENTITY(1,1) NOT NULL,
    [nombre] [nvarchar](100) NOT NULL,
    [email] [nvarchar](100) NOT NULL,
    [empresa] [nvarchar](100) NULL,
    [fecha_creacion] [datetime] DEFAULT GETDATE(),
    [telefono] [nvarchar](50) NULL,
    [direccion] [nvarchar](255) NULL,
    [estado_id] [int] NOT NULL,
    [cedula] [nvarchar](50) NULL,
    [servicio] [nvarchar](100) NULL,
    [especialidad] [nvarchar](100) NULL,
	
    CONSTRAINT [PK_lista_contactos] PRIMARY KEY CLUSTERED ([id] ASC),
    CONSTRAINT [FK_contactos_estados] FOREIGN KEY ([estado_id]) 
        REFERENCES [dbo].[estados_clientes]([id]) 
        ON UPDATE CASCADE
) ON [PRIMARY];