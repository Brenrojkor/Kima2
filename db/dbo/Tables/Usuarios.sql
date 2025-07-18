-- =====================================================
-- Object:  Table [dbo].[TiposProductos]
-- Script Date: 19/4/2025 11:40:26
-- =====================================================

CREATE TABLE [dbo].[Usuarios] (
    [ID] [int] IDENTITY(1,1) NOT NULL,
    [Nombre] [varchar](50) NOT NULL,
    [Email] [varchar](100) NOT NULL,
    [Contraseña] [varchar](255) NOT NULL,
    [Rol] [nvarchar](15) NOT NULL DEFAULT 'Usr',
    [estado_id] [int] NULL,
    [ImagenPerfil] [varchar](255) NULL,
    
    CONSTRAINT PK_Usuarios PRIMARY KEY CLUSTERED ([ID] ASC),
    CONSTRAINT UQ_Usuarios_Email UNIQUE NONCLUSTERED ([Email] ASC),
    CONSTRAINT FK_usuarios_estados FOREIGN KEY ([estado_id]) 
        REFERENCES [dbo].[estados_clientes] ([id]),
    CONSTRAINT CK_Usuarios_Rol CHECK ([Rol] = 'Admin' OR [Rol] = 'Usr')
) ON [PRIMARY];